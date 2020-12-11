<template>
    <main id="job_single" v-if="Object.keys(job_data).length">
        <div class="container-placeholder" v-if="!job_data.title"></div>
        <div class="single-job-container" v-if="job_data.title">
            <h3>{{ job_data.title }}</h3>
            <div class="other-details-container">
                <p class="date" v-if="job_data.date_posted">{{ job_data.date_posted }}</p>
                <p class="salary" v-if="job_data.salary">{{ job_data.salary }}</p>
                <p class="job-type" v-if="job_data.job_type.id">{{ job_data.job_type.name }}</p>
                <p class="company-name" v-if="job_data.company_name">{{ job_data.company_name }}</p>
                <p class="location">{{ job_data.job_location || 'Anywhere' }}</p>
            </div>
            <div class="content" v-html="job_data.content"></div>
        </div>
        <div class="action-buttons-container">
            <div class="action-buttons">
                <a class="action-item" :class="job_data.apply.email ? '' : 'not-available'" href="javascript:void(0)" v-on:click="show_modal_form" title="Apply via Email">
                    <img src="../assets/envelope-solid.svg" alt="Email Icon">
                </a>
                <a class="action-item" :class="job_data.apply.mobile || job_data.apply.tel ? '' : 'not-available'" href="javascript:void(0)" v-on:click="show_modal_call" title="Apply via Call">
                    <img src="../assets/phone-alt-solid.svg" alt="Call Icon">
                </a>
                <a class="action-item"
                   :class="job_data.apply.url ? '' : 'not-available'"
                   :href="job_data.apply.url || 'javascript:void(0)'"
                   :target="job_data.apply.url ? '_blank' : '_self'"
                   title="Apply via Application Form"
                >
                    <img src="../assets/file-alt-solid.svg" alt="Application Form Icon">
                </a>
            </div>
        </div>
        <div class="modal-call" v-if="show_call_choices">
            <a class="call-item" v-if="job_data.apply.mobile" :href="`tel:${job_data.apply.mobile}`">
                <img src="../assets/mobile-alt-solid.svg" alt="Call Icon">
            </a>
            <a class="call-item" v-if="job_data.apply.tel" :href="`tel:${job_data.apply.tel}`">
                <img src="../assets/phone-alt-solid.svg" alt="Call Icon">
            </a>
        </div>
        <div class="modal-form" v-if="show_application_form">
            <form v-on:submit.prevent="form_submit" ref="application" autocomplete="off" enctype="multipart/form-data">
                <div class="form-field form-heading">
                    <h3>Send Application {{ form_submission_interval ? '(' + form_submission_interval + ')' : '' }}</h3>
                </div>
                <div class="message" :class="application_response.status == 1 ? 'success' : 'error'" :data-response="Object.keys(application_response).length" v-show="Object.keys(application_response).length">
                    {{ application_response.message }}
                </div>
                <div>
                    <input class="form-data" type="hidden" name="mailto" :value="job_data.apply.email" />
                    <input class="form-data" type="hidden" name="key" :value="encryptor" />
                    <input class="form-data" type="hidden" name="job_id" :value="job_data.job_id" />
                </div>
                <div class="form-phase phase-1" v-show="form_phase.phase_1">
                    <div class="form-field">
                        <input class="field-input form-data" type="text" name="name" placeholder="Full Name" required/>
                    </div>
                    <div class="form-field">
                        <input class="field-input form-data" type="text" name="email" placeholder="Email" required/>
                    </div>
                    <div class="form-field">
                        <input class="field-input form-data" type="text" name="phone" placeholder="Phone" />
                    </div>
                    <div class="form-field">
                        <a class="button" href="javascript:void(0)" v-on:click="phaseTo(2, 1)">Next</a>
                    </div>
                </div>
                <div class="form-phase phase-2" v-show="form_phase.phase_2">
                    <div class="form-field">
                        <input class="field-input form-data" type="text" name="subject" placeholder="Subject"/>
                    </div>
                    <div class="form-field">
                        <textarea class="field-textarea form-data" name="message" rows="5" placeholder="Message"></textarea>
                    </div>
                    <div class="form-field">
                        <a class="button" href="javascript:void(0)" v-on:click="phaseTo(3, 2)">Next</a>
                    </div>
                    <div class="form-field">
                        <a class="button" href="javascript:void(0)" v-on:click="phaseTo(1)">Back</a>
                    </div>
                </div>
                <div class="form-phase phase-3" v-show="form_phase.phase_3">
                    <div class="form-field">
                        <label>Submit Resume/CV</label>
                        <input class="d-block form-data" type="file" name="cv" />
                    </div>
                    <div class="form-check form-field">
                        <input type="checkbox" class="form-check-input form-data" id="form_checkbox" name="approve_mailing" value="true" checked>
                        <label class="form-check-label" for="form_checkbox">Subscribe to our mailing list. You'll receive latest jobs updates, tips, and other free services.</label>
                    </div>
                    <div class="form-field">
                        <input class="button" type="submit" value="Send Application" />
                    </div>
                    <div class="form-field">
                        <a class="button" href="javascript:void(0)" v-on:click="phaseTo(2)">Back</a>
                    </div>
                </div>
                
            </form>
        </div>
    </main>
</template>
<script>
import { ApiURL, encryptor, IsEmail, IsPhone, capitalize } from '../helpers'
export default {
    data() {
        return {
            job_data: [],
            show_call_choices: false,
            show_application_form: false,
            form_phase: {
                phase_1: true,
                phase_2: false,
                phase_3: false
            },
            application_response: [],
            form_submission_interval: 0,
            encryptor: ''
        }
    },
    methods: {
        show_modal_call() {
            this.show_application_form = false
            this.application_response = []
            this.phase_reset()
            this.show_call_choices = this.show_call_choices == true ? false : true
        },
        show_modal_form() {
            this.show_call_choices = false
            this.phase_reset()
            this.show_application_form = this.show_application_form == true ? false : true
            this.application_response = []
        },
        phaseTo( phase, current_phase = null ) {
            let move_to_next = true
            
            if( current_phase != null ) {
                let phase_inputs = document.querySelectorAll('.phase-'+ current_phase + ' .form-data')
                phase_inputs.forEach( (item) => {

                    if( item.required && item.value == '' ) {
                        this.application_response = {
                            message: capitalize( item.name ) + ' field must be filled'
                        }
                        move_to_next = false
                        return
                    }

                    if( item.name == 'email' && IsEmail( item.value ) === false ) {
                        this.application_response = {
                            message: capitalize( item.name ) + ' is invalid'
                        }
                        move_to_next = false
                        return
                    }

                    if( item.name == 'phone' && item.value !== "" && IsPhone( item.value ) == false ) {
                        this.application_response = {
                            message: capitalize( item.name ) + ' is not valid'
                        }
                        move_to_next = false
                        return
                    }

                    if( item.name == 'subject' && item.value == "" ) {
                        this.application_response = {
                            message: capitalize( item.name ) + ' cannot be empty'
                        }
                        move_to_next = false
                        return
                    }
                    console.log( this.application_response )
                } )
            }

            if( move_to_next ) {
                Object.keys(this.form_phase).forEach((item) => {
                    this.form_phase[item] = false
                })
                this.form_phase[ 'phase_' + phase ] = true
                this.application_response = []
            }
            
        },
        phase_reset() {
            this.form_phase = {
                phase_1: true,
                phase_2: false,
                phase_3: false
            }
        },
        reset_form() {
            this.$refs.application.reset()
            this.phaseTo(1)
        },
        start_application_timer() {
            this.form_submission_interval = 30
            let submit = this.$refs.application.querySelector('input[type="submit"]')
            var timer = setInterval( () => {
                submit.disabled = true
                if( this.form_submission_interval == 1 ) {
                    clearInterval( timer )
                    submit.disabled = false
                }
                this.form_submission_interval -= 1
            }, 1000 )
        },
        form_submit() {
            this.$refs.application.querySelector('input[type="submit"]').disabled = true
            if( this.form_submission_interval !== 0 ) {
                this.application_response = {
                    status: 0,
                    message: 'You cannot submit application yet'
                }
                return false
            }

            let formData = new FormData()
            let form = this.$refs.application.querySelectorAll( '.form-data' )
            form.forEach((item) => {
                let file_name = ""
                let value = item.value
                // Append Value for File
                if( item.name == 'cv' && item.files.length ) {
                    file_name = item.files[0].name;
                    value = item.files[0]
                    formData.append( item.name, value, file_name )
                    return
                }
                formData.append( item.name, value )
            })
            /*
            for (var p of formData) {
                let name = p[0];
                let value = p[1];

                console.log(name + ' -', value)
            }
            */
            this.$http.post(
                ApiURL + '/send_application',
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
                    this.reset_form()
                    this.application_response = {
                        status: response.body.status,
                        message: response.body.message
                    }
                    this.start_application_timer()
                }
            })
        }
    },
    created () {
        let job_id = this.$route.params.id
        this.get_job( job_id )
        this.encryptor = encryptor( 'jobemployph' )
    }
}
</script>
<style scoped>
* {
    color: #183c40;
}
.single-job-container {
    background: #fff;
    padding: 30px;
}
.other-details-container {
    background: #eaeaea;
    padding: 20px 20px;
    margin: 0 0 30px;
    column-count: 2;
    column-fill: balance;
}
.other-details-container p {
    color: #dd8041;
    font-size: 10px;
    font-weight: bold;
    margin-top: 0;
}
.content,
.content * {
    font-size: 12px !important;
    white-space: break-spaces;
    pointer-events: none;
}
.action-buttons {
    width: 100%;
    position: fixed;
    left: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #dd8041;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    height: 60px;
}
.action-item {
    width: 33.33%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.action-item.not-available {
    background: #afafaf;
    pointer-events: none;
}
.action-item:hover {
    background: #183c40;
}
.action-item img {
    width: 30px;
    height: 30px;
    filter: invert(1)
}
.modal-call {
    position: fixed;
    width: 100%;
    left: 0;
    bottom: 80px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.call-item {
    background: #fff;
    padding: 20px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
    border-radius: 20px;
}
.call-item:first-child {
    margin-right: 10px;
}
.call-item img {
    width: 40px;
    height: 40px;
}
.modal-form {
    position: fixed;
    left: 50%;
    bottom: 80px;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    background: #fff;
    border: 1px solid #183c40;
    padding: 30px;
}
.modal-form input:not([type="checkbox"]),
.modal-form textarea {
    width: 100%
}

.modal-form .button {
    color: #fff;
}
</style>