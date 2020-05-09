<template>
    <div class="comment">
        <div class="parent-comment">
            <div class="comment-header">
                <span v-if="comment.authorId == contentAuthorId" class="comment-author">{{comment.name}}</span>
                <span v-else-if="comment.authorId" class="comment-member">{{comment.name}}</span>
                <span v-else class="comment-name">{{comment.name}}</span>
                <span v-localdate :format="'yyyy-MM-dd'" class="comment-datetime">{{comment.created_at}}</span>
            </div>

            <div class="comment-body">
                {{comment.body}}
            </div>

            <div class="comment-footer">
                <a v-if="allowNested && maxDepth >= currentDepth" class="comment-reply" @click="replyBox(comment.id)">{{ replyBtnText(comment.id) }}</a>
                <comment-box v-if="showReplyBox(comment.id)" :comment-id="comment.id"></comment-box>
            </div>
        </div>

        <div v-if="comment.status==2" style="font-weight: bold;">This comment is pending approval.</div>

        <div v-if="comments.length && (allowNested && maxDepth >= currentDepth)" class="nested-comment">
            <comments-tree v-for="comment in comments"
                :comment="comment"
                :depth="currentDepth"
                :allowNested="allowNested"
                :maxDepth="maxDepth"
                :key="comment.id">
            </comments-tree>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return {

            }
        },
        props: {
            comment: { type: Object, default: null },
            depth: { type: Number, default: 0 },
            allowNested: { type: Boolean, default: false },
            maxDepth: { type: Number, default: 0 }
        },
        computed: {
            currentDepth() {
                return this.depth + 1
            },
            comments: {
                get() {
                    return this.$store.getters.comments(this.comment.id)
                }
            },
            replyToComment: {
                get() {
                    return this.$store.getters.replyToComment
                },
                set(val) {
                    this.setReplyToComment(val)
                }
            },
            replyingToComment: {
                get() {
                    return this.$store.getters.replyingToComment
                },
                set(val) {
                    this.setReplyingToComment(val)
                }
            },
            contentAuthorId: {
                get() {
                    return this.$store.getters.contentAuthorId
                }
            },
            postingComment: {
                get() {
                    return this.$store.getters.postingComment
                }
            },
        },
        methods: {
            ...mapActions([
                'setReplyingToComment',
                'setReplyToComment'
            ]),
            replyBtnText(commentId) {
                if(this.replyToComment == commentId) {
                    return this.replyBtnTextString = 'Cancel'
                } else {
                    return this.replyBtnTextString = 'Reply'
                }
            },
            replyBox(commentId) {
                if(this.replyToComment == commentId) {
                    this.replyToComment = 0
                    this.replyingToComment = false
                } else {
                    this.replyToComment = commentId
                    this.replyingToComment = true
                }
            },
            showReplyBox(commentId) {
                if(this.replyToComment == commentId)
                    return true
                else
                    return false
            },

        }
    }
</script>