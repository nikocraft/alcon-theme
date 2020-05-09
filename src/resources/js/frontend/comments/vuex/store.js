import Vue from 'vue';
import Vuex from 'vuex';
import sortBy from 'lodash/sortBy';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        contentId: 0,
        replyToComment: null,
        comments: {},
        user: null,
        rootCommentsList: [],
        commentsLoaded: false,
        replyingToComment: false,
        postingComment: false,
        commentPosted: false,
        contentAuthorId: null,
        commentForm: {
            name: '',
            email: '',
            body: '',
            website: '',
        }
    },

    getters: {
        rootComments(state) {
            return state.rootCommentsList.map( id => state.comments[id] )
        },
        comments: (state, getters) => (parent) => {
            if (!parent) return []
            let comment = state.comments[parent]
            return comment.comments.map( id => state.comments[id] )
        },
        user(state) {
            return state.user
        },
        contentAuthorId(state) {
            return state.contentAuthorId
        },
        commentsLoaded(state) {
            return state.commentsLoaded
        },
        postingComment(state) {
            return state.postingComment
        },
        replyingToComment(state) {
            return state.replyingToComment
        },
        replyToComment(state) {
            return state.replyToComment
        },
    },

    mutations: {
        SET_CONTENT_ID(state, payload) {
            state.contentId = payload
        },
        SET_CONTENT_AUTHOR_ID(state, payload) {
            let { contentAuthorId } = payload
            state.contentAuthorId = contentAuthorId
        },
        SET_REPLY_TO_COMMENT(state, payload) {
            state.replyToComment = payload
        },
        SET_REPLYING_TO_COMMENT(state, payload) {
            state.replyingToComment = payload
        },
        setUser(state, payload) {
            let { id, firstname, lastname, username, email } = payload

            let user = {
                id: id,
                firstname: firstname,
                lastname: lastname,
                email: email,
                username: username
            }

            state.user = user

        },
        ADD_COMMENT(state, payload) {
            let { id, authorId, name, email, body, parent, status, created_at } = payload

            let newComment = {
                id: id,
                authorId, authorId,
                name: name,
                email: email,
                body: body,
                parent: parent,
                status: status,
                created_at: created_at,
                comments: []
            }

            // insert comment into comments object list, key is comment id...
            Vue.set(state.comments, id, newComment)

            // if comment has a parent then fetch parent and insert comment id into parent comments list...
            if (parent) {
                let comment = state.comments[parent]
                comment.comments.push(id)
            } else {
                // otherwise this is root comment, insert it into rootComments list...
                state.rootCommentsList.push(id)
            }
        },
    },

    actions: {
        setContentId({ commit }, payload) {
            commit('SET_CONTENT_ID', payload)
        },
        setReplyToComment({ commit }, payload) {
            commit('SET_REPLY_TO_COMMENT', payload)
        },
        setReplyingToComment({ commit }, payload) {
            commit('SET_REPLYING_TO_COMMENT', payload)
        },
        postComment({ commit, getters, state }, payload) {
            let { name, email, body, website } = payload

            let commentData = {
                content_id: state.contentId,
                parent_id: state.replyToComment,
                name: name,
                email: email,
                body: body,
                website: website
            }

            state.postingComment = true

            return new Promise((resolve, reject) => {
                axios.post(route('frontend.comments.store'), commentData)
                    .then((response) => {
                        state.postingComment = false
                        state.commentPosted = true
                        state.replyToComment = null
                        state.replyingToComment = false
                        let comment = response.data.comment

                        let authorId = null
                        if(comment.author) {
                            authorId = comment.author.id
                        }

                        commit('ADD_COMMENT', {
                            id: comment.id,
                            authorId: authorId,
                            name: comment.name,
                            email: comment.email,
                            body: comment.body,
                            parent: comment.parent_id ? comment.parent_id : null,
                            status: comment.status,
                            created_at: comment.created_at
                        })
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })
        },
        fetchComments({ commit, getters, state }, payload) {
            let { contentId, order = 'asc', contentAuthorId } = payload
            axios.get(route('frontend.comments.index', {content: contentId}))
            .then((response) => {
                let comments = sortBy(response.data.comments, [
                    ( o ) => { return o.parent || 0},
                    'id'
                ])
                if(order === 'desc') comments = comments.reverse()

                comments.forEach(function(object) {
                    let authorId = null
                    if(object.author) {
                        authorId = object.author.id
                    }

                    commit('SET_CONTENT_AUTHOR_ID', {
                        contentAuthorId: 1,
                    })

                    commit('ADD_COMMENT', {
                        id: object.id,
                        authorId: authorId,
                        name: object.name,
                        email: object.email,
                        body: object.body,
                        parent: object.parent_id ? object.parent_id : null,
                        status: object.status,
                        created_at: object.created_at
                    })
                })

                if(response.data.user)
                    commit('setUser', {
                        id: response.data.user.id,
                        firstname: response.data.user.firstname,
                        lastname: response.data.user.lastname,
                        username: response.data.user.username,
                        email: response.data.user.email,
                    })

                state.commentsLoaded = true
            })
            .catch((error) => {
                console.log(error)
            })
        }
    }
});
