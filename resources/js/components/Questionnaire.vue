<template>
    <div id="questionnaire">

        <div class="bg-info progress" :style="{width: completionRate}"/>

        <div class="card shadow-sm p-4">
            <div class="card-body p-0">
                <div class="d-flex justify-content-between">
                    <h3 class="text-info" v-text="`Question ${currentQuestionIndex + 1} of ${questions.length}`"/>
                    <h3 class="text-info" v-text="completionRate"></h3>
                </div>


                <h4 class="py-3" v-text="currentQuestion.title"/>

                <ul ref="answersList">
                    <li v-for="answer in currentQuestion.answers" :key='answer.id' class="position-relative">
                        <input type="radio"
                               class="position-absolute"
                               :name="`question_${currentQuestion.id}`"
                               :data-question="currentQuestion.id"
                               :value="answer.id"
                               :checked="answers.findIndex(a=>a.id===answer.id) !== -1"
                               :id="`answer_${answer.id}`"
                        >
                        <label class="ml-3" :for="`answer_${answer.id}`">{{ answer.label }}</label>
                    </li>
                </ul>

                <div class="pt-4 d-flex align-items-center justify-content-between">
                    <div>
                        <a class="btn btn-outline-info" href="#" @click.prevent="goToPreviousQuestion">Previous</a>
                        <a class="btn btn-info"
                           href="#"
                           @click.prevent="goToNextQuestion"
                           v-text="'Next'"
                        ></a>
                    </div>

                    <div v-if="answers.length === questions.length" class="position-relative">
                        <vue-spinner v-if="loading"/>
                        <a :disabled="loading" @click.prevent="updateTestAnswers" class="btn btn-white"
                           :href="redirectUrl">Finish</a>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    name: "Questionnaire",
    props: ['questions', 'initialAnswers', 'completeUrl', 'redirectUrl'],
    data() {
        return {
            currentQuestion: null,
            answers: this.initialAnswers,
            loading: false
        }
    },
    created() {
        this.currentQuestion = this.questions[0]
    },
    computed: {
        completionRate() {
            return (this.answers.length / this.questions.length * 100).toFixed(0) + '%'
        },
        currentQuestionIndex() {
            return this.questions.findIndex(q => q.id === this.currentQuestion.id)
        }
    },
    methods: {
        goToNextQuestion() {
            this.updateAnswer()
            this.chooseNextQuestion();
        },
        goToPreviousQuestion() {
            this.updateAnswer()
            this.choosePreviousQuestion();
        },
        chooseNextQuestion() {
            this.changeQuestion(this.currentQuestionIndex + 1)
        },
        choosePreviousQuestion() {
            this.changeQuestion(this.currentQuestionIndex - 1)
        },
        changeQuestion(index) {
            if (index < 0 || index > this.questions.length - 1) return;

            this.currentQuestion = this.questions[index]
        },
        updateAnswer() {
            const answerInput = this.$refs.answersList.querySelector('input:checked')

            const formerAnswerIndex = this.answers.findIndex(a => a.question_id == this.currentQuestion.id)
            if (formerAnswerIndex !== -1) {
                this.answers.splice(formerAnswerIndex, 1)
            }

            if (answerInput) {
                this.answers.push(this.currentQuestion.answers.find(a => a.id == answerInput.value))
            }
        },
        updateTestAnswers() {
            if (this.loading) return

            this.loading = true

            axios.put(this.completeUrl, {
                answers: this.answers.map(a => a.id)
            })
                .then(({data}) => {
                    window.location = this.redirectUrl
                })
                .catch((e) => {
                    this.loading = false
                })
        }
    },
}
</script>

<style lang="scss" scoped>
#questionnaire {

    .progress {
        transition: width .4s;
        height: 3px;
    }

    ul {
        list-style: none;
        padding-left: 0;

        li {
            input {
                margin-top: 6px;
            }

            label {
                cursor: pointer;
            }
        }
    }

}
</style>
