<template>
  <div class="py-5 px-8">
    <div v-if="loading" class="flex justify-center">Loading...</div>
    <form @submit.prevent="submitSurvey" v-else class="container mx-auto">
      <div class="grid grid-cols-6 items-center">
        <div class="mr-4">
          <img :src="survey.image_url" alt="" />
        </div>
        <div class="col-span-5">
          <h1 class="text-3xl mb-3">{{ survey.title }}</h1>
          <p class="text-gray-500 text-sm" v-html="survey.description"></p>
        </div>
      </div>

<!--      <div v-if="surveyFinished" class="py-8 px-6 bg-emerald-400 text-white w-[600px] mx-auto">-->
<!--        <div class="text-xl mb-3 font-semibold ">Thank you for participating in this survey.</div>-->
<!--        <button @click="submitAnotherResponse" type="button" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">-->
<!--          Submit another response-->
<!--        </button>-->
<!--      </div>-->
      <div >
        <hr class="my-3">
        <div v-for="(question, ind) of survey.questions" :key="question.id">
          <QuestionViewer
            v-model="answers[question.id]"
            :question="question"
            :index="ind"
          />
        </div>

        <button
          type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
            <div class="ml-3 spinner-border spinner-border-sm text-light spinner-loading"
                 v-if="isLoading"  role="status">
            </div>
          ارسال
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import QuestionViewer from "../components/viewer/QuestionViewer.vue";
const props = defineProps({
    survey_id:Number,
    trainingLink: String,
});

const route = useRoute();
const store = useStore();

const loading = computed(() => store.state.currentSurvey.loading);
const survey = computed(() => store.state.currentSurvey.data);

const surveyFinished = ref(false);

const answers = ref({});
let isLoading = ref(false);
store.dispatch("getSurveyById", props.survey_id);
onMounted(() => {

        console.log(props.survey_id);
    }
);
function submitSurvey() {
    isLoading.value=true;
  // console.log(JSON.stringify(answers.value, undefined, 2));
  store.dispatch("saveSurveyAnswer", {
      surveyId: survey.value.id,
      answers: answers.value,
    })
    .then((response) => {

      if (response.status === 201) {
          isLoading.value=false;
          Swal.fire({
              icon: "success",
              title:'شكراً',
              text: "شكرا لتعبئة الاستبيان",
              showConfirmButton: false,
              timer: 3500, // Adjust the time (in milliseconds) you want the message to be visible before automatically closing.
          });
          setTimeout(()=>{

              surveyFinished.value = false;
              window.location.href = props.trainingLink;
          },3400)

      }
    }).catch(()=>{
      isLoading.value=false;
  });
}

function submitAnotherResponse() {
  answers.value = {};
  surveyFinished.value = false;
}
</script>

<style></style>
