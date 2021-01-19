<template>
    <div class="row">
        <div class="col-lg-12">
            <div v-for="(question, index) in questions" :key="index">
               <div v-show="index === questionIndex">
                   <h2>{{ question.question_text }}</h2>
                    <div class="row">
                        <div class="col-lg-4">
                            <img class="img-fluid" :src="question.question_image" alt="">
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="form-group"  v-for="response in question.question_response">
                                   <div class="col-lg-6">
                                       <label>

                                           <input type="radio"
                                                  v-bind:value="response"
                                                  v-bind:name="index"
                                                  v-model="userResponses[index]" @click="storeAnswer(index, response, question.question_id, question.question_text)"> {{response}}
                                       </label>
                                   </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>

           </div>
            <div v-show="questionLength === questionIndex" class="mb-2 mt-4">
                <h4>Answers</h4>
                <hr>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Answer</th>
                    </tr>
                    </thead>
                    <tr v-for="(question, index) in questionText">
                        <td>{{question}}</td>
                        <td>{{userResponses[index]}}</td>
                    </tr>
                </table>
            </div>
            <button v-if="questionIndex > 0" @click="prev" class="btn btn-secondary">
                prev
            </button>
            <button v-if="questionLength === questionIndex" @click="submitAnswers()" class="btn btn-success">
                Submit
            </button>
            <button v-else @click="next" class="btn btn-success">
                Next
            </button>
            <div v-show="loading" id="loader"></div>
        </div>
    </div>
</template>

<script>
export default {
name: "MedicalExamination",
    props:['patient','appointment'],
    data(){
        return{
            questions: [],
            userResponses: [],
            questionIndex: 0,
            userQuestions: [],
            questionLength: 0,
            questionText: [],
            loading: false,
            question_url : '../../../medical-examination-questions',
            question_save_url : '../../../medical-examination',

        }
    },
    methods: {
        getMedicalQuestions() {
            axios.get(this.question_url)
            .then((response)=>{
                this.questions = response.data.data
                this.questionLength = this.questions.length
            })
            .catch((error)=>{
                console.log(error.response.data.errors);
            })
        },
        next: function() {
            if (this.userResponses[this.questionIndex]) {
                this.questionIndex++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please answer the question'
                })
            }

        },
        // Go to previous question
        prev: function() {
            this.questionIndex--;
        },
        storeAnswer(index, answer, question, text){

            this.userResponses[index] = answer
            this.userQuestions[index] = question
            this.questionText[index] = text
        },
        submitAnswers()
        {
            this.loading = true;
            let form = new FormData();
            form.append('questions', this.userQuestions);
            form.append('answers', this.userResponses);
            form.append('patient', this.patient);
            form.append('appointment', this.appointment);

            axios.post(this.question_save_url, form)
            .then((response)=>{
                Swal.fire({
                    icon: 'success',
                    title: 'OK',
                    text: response.data.message
                })
                window.setTimeout(function () {
                    window.location = response.data.url;
                }, 1000);

            })
            .catch((error)=>{
                this.loading = false
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong'
                })
            })
        }

    },
    mounted() {
        this.getMedicalQuestions()
    }

}
</script>

<style scoped>

</style>
