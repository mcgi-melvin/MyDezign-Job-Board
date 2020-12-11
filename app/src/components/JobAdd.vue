<template>
    <main>
        <form v-on:submit.prevent="submit_form" ref="post_job" autocomplete="off">
            <div class="message" :class="post_response.status == 1 ? 'success' : 'error'" v-if="Object.keys(post_response).length">
                {{ post_response.message }}
            </div>
            <div class="interval-message" v-if="post_interval > 0">
                You cannot post a job yet ( {{ post_interval }} )
            </div>
            <div class="form-heading">
                <h3>Basic Information</h3>
            </div>
            <div>
                <input class="form-data" type="hidden" name="author" :value="author" />
                <input class="form-data" type="hidden" name="key" :value="encryptor" />
            </div>
            <div class="form-field">
                <input class="field-input form-data" type="text" name="job_title" placeholder="Enter Title" required/>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <input class="field-input form-data" type="text" name="job_salary" placeholder="Enter Salary" />
                </div>
                <div class="form-field">
                    <input class="field-input form-data" type="text" name="job_location" placeholder="Enter Location" />
                </div>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <select class="field-input form-data" name="job_type">
                        <option value="0">Select Type</option>
                        <option v-for="type in types" :key="type.id" :value="type.id" v-html="type.name"></option>
                    </select>
                </div>
                <div class="form-field">
                    <select class="field-input form-data" name="job_category">
                        <option value="0">Select Category</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id" v-html="category.name">
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-field">
                <wysiwyg v-model="body_content" placeholder="Description" />
                <textarea class="form-data" name="job_description" v-model="body_content"></textarea>
            </div>
            <div class="form-heading">
                <h3>Contact Information</h3>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <input class="field-input form-data" type="text" name="application_mobile" placeholder="Mobile Number" />
                </div>
                <div class="form-field">
                    <input class="field-input form-data" type="text" name="application_tel" placeholder="Tel Number" />
                </div>
            </div>
            <div class="form-group">
                <div class="form-field">
                    <input class="field-input form-data" type="email" name="application_email" placeholder="Email" />
                </div>
                <div class="form-field">
                    <input class="field-input form-data" type="text" name="application_link" placeholder="Application Link" />
                </div>
            </div>
            <div class="form-heading">
                <h3>Company Details</h3>
            </div>
            <div class="form-field">
                <input class="field-input form-data" type="text" name="company_name" placeholder="Company Name" />
            </div>
            <div class="form-field">
                <input class="field-input form-data" type="text" name="company_website" placeholder="Company Website" />
            </div>
            <div class="form-field">
                <input class="button" type="submit" value="Submit" />
            </div>
        </form>
    </main>
</template>

<script>
import { ApiURL, encryptor, IsEmail, IsPhone } from '../helpers'
export default {
    data() {
        return {
            types: [],
            categories: [],
            body_content: "",
            post_response: [],
            post_interval: 0,
            encryptor: null,
            author: 0
        }
    },
    methods: {
        get_taxonomies() {
            this.$http.get( ApiURL + '/taxonomies').then( function( response ) {
                if( response.status == 200 ) {
                    this.types = response.body.job_types
                    this.categories = response.body.job_categories
                }
            });
        },
        start_interval() {
            this.post_interval = 30
            var button = this.$refs.post_job.querySelector('input[type="submit"]')
            var timer = setInterval( () => {
                button.disabled = true
                if( this.post_interval == 1 ) {
                    clearInterval(timer)
                    button.disabled = false
                }
                this.post_interval -= 1
            }, 1000)
        },
        set_response(message, status) {
            this.post_response = {
                status: status || 0,
                message: message
            }
        },
        reset_form() {
            this.$refs.post_job.reset()
            this.body_content = ""
        },
        submit_form() {
            this.post_response = []
            let formData = new FormData()
            let ready_to_submit = true

            this.$refs.post_job.querySelector('input[type="submit"]').disabled = true
            if( this.post_interval !== 0 ) {
                this.post_response = {
                    message: 'You cannot post a job yet'
                }
                return false;
            }
            
            let form_fields = this.$refs.post_job.querySelectorAll('.form-data')
            form_fields.forEach(element => {
                if( element.name == "application_email" && element.value != "" && IsEmail( element.value ) == false ) {
                    this.set_response( "Email is not valid" )
                    ready_to_submit = false
                    return false
                }
                if( element.name == "application_mobile" && element.value != "" && IsPhone( element.value ) == false ) {
                    this.set_response( "Phone is not valid" )
                    ready_to_submit = false
                    return false
                }
                formData.append( element.name, element.value )
            });

            
            
            if( ready_to_submit ) {
                
                this.$http.post(
                    ApiURL + '/post_job',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        },
                        emulateJSON: true
                    }
                ).then( (response) => {
                    if( response.status == 200 ) {
                        console.log( response )
                        this.post_response = {
                            status: response.body.status,
                            message: response.body.message
                        }
                        this.start_interval()
                        this.reset_form()
                    }
                })
                
            }
            

            
        }
    },
    created() {
        this.get_taxonomies()
        this.encryptor = encryptor( 'jobemployph_post_job' )
    }
}
</script>

<style scoped>
@import "~vue-wysiwyg/dist/vueWysiwyg.css";
form {
    background: #fff;
    padding: 30px;
}
form textarea {
    display: none;
}
.interval-message {
    color: #fff;
    background: #dd8041;
    padding: 10px 20px;
    margin-bottom: 10px;
}
</style>