<template>
    <div class="comment-box">
        <div class="comment-form">
            <div class="comment-box-header">
                <h3>Leave a Reply</h3>
                <div class="comment-box-header-info">Your email address will not be published. Required fields are marked *</div>
            </div>

            <div class="comment-body">
                <label for="body">Comment</label> *
                <textarea v-validate="'required'" data-vv-as="Comment" name="body" class="form-input" v-model="body"></textarea>
                <span>{{ errors.first('body') }}</span>
            </div>

            <div v-if="!loggedUser" class="comment-data">
                <div class="comment-data-item">
                    <label for="name">Name</label> *
                    <input v-validate="'required'" data-vv-as="Name" name="name" type="text" class="form-input" v-model="name">
                    <span>{{ errors.first('name') }}</span>
                </div>
            
                <div class="comment-data-item">
                    <label for="email">Email</label> *
                    <input v-validate="'required|email'" data-vv-as="Email" name="email" type="text" class="form-input" v-model="email">
                    <span>{{ errors.first('email') }}</span>
                </div>
            </div>

            <div v-if="successfulPost" style="text-align: center;">Comment successfully posted. Comment may need to be moderated before appearing.</div>
            <div v-if="errorStatus" style="text-align: center; color: #ff4a57;">Server responded with an error, the comment could not be posted.</div>

            <div class="comment-btn">
                <button v-if="!postingOngoing" @click="submit()" type="submit" name="button" class="btn btn-primary">Post Comment</button>
                <button v-else name="button" class="btn btn-primary">Posting...</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data () {
            return {
                name: '',
                email: '',
                body: '',
                errorStatus: false,
                successfulPost: false,
                postingOngoing: false
            }
        },
        props: {
            commentId: { type: Number, default: null},
        },
        computed: {
            replyToComment: {
                get() {
                    return this.$store.getters.replyToComment
                },
                set(val) {
                    this.setReplyToComment(val)
                }
            },
            postingComment: {
                get() {
                    return this.$store.getters.postingComment
                }
            },
            loggedUser: {
                get() {
                    return this.$store.getters.user
                }
            },
        },
        methods: {
            ...mapActions([
                'postComment'
            ]),
            submit(commentId) {
                this.$validator.validateAll().then((result) =>{
                    if(result) {
                        this.postingOngoing = true
                        this.successfulPost = false
                        this.errorStatus = false
                        let payload = {
                            name: this.name,
                            email: this.email,
                            body: this.body,
                        }
                        this.postComment(payload)
                            .then(() => {
                                this.name = ''
                                this.email = ''
                                this.body = ''
                                this.postingOngoing = false
                                this.successfulPost = true

                                this.$nextTick(() => {
                                    this.errors.clear();
                                    this.$nextTick(() => {
                                        this.$validator.reset();
                                    });
                                });
                            })
                            .catch((error) => {
                                this.postingOngoing = false
                                this.successfulPost = false
                                this.errorStatus = error.response.status
                            })
                    } else {
                        this.successfulPost = false
                    }
                })
            },
        }
    }
</script>