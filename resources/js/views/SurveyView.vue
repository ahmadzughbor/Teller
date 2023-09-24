<template>
    <PageComponent>
        <template v-slot:header>

        </template>
        <div v-if="surveyLoading" class="flex justify-center">Loading...</div>
        <Form v-else   @submit="saveSurvey" :validation-schema="schema" class="animate-fade-in-down" ref="surveyForm" :key="componentKey"  >
            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <!-- Survey Fields -->
                <div class=" grid-cols-12 gap-y-2 items-center px-5">
                  <!-- image -->
                  <div class="col-span-2">
                         <label class="block al text-sm font-medium text-gray-700">
                            صورة الاستبيان
                        </label>
                  </div>
                  <div class="col-span-10">
                    <div class="mt-1 flex items-center">
                      <img v-if="model.image_url" :src="model.image_url" :alt="model.title"
                          class="w-64 h-48 object-cover" />
                      <span v-else
                          class="flex items-center justify-center h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-[80%] w-[80%] text-gray-300"
                              viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd"
                                  d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                                  clip-rule="evenodd" />
                          </svg>
                      </span>
                      <button type="button"
                          class="relative
                           overflow-hidden ml-5
                           bg-white py-2 px-3 border border-gray-300 rounded-md
                          shadow-sm text-sm  font-medium text-gray-700 ">


                          <Field type="file"  name="image" @change="onImageChoose" accept="image/*"
                              class="absolute left-0 top-0 right-0 bottom-0 opacity-0 cursor-pointer " style="display: -webkit-box"  />
                          تغيير
                      </button>
                  </div>
                      <ErrorMessage name="image" class="error-message mt-1"  />
                  </div>
                  <!-- end Image -->
                  <!-- title -->
                  <div class="col-span-2">
                    <label for="title" class="text-sm font-medium text-gray-700">{{t('survey_title')}}</label>
                  </div>
                  <div class="col-span-10">
                    <Field type="text" name="title" id="title" placeholder="عنوان الاستبيان" v-model="model.title" autocomplete="survey_title"
                    class="keyword-input with-border"
                    :class="{'invalid-input':errors.title??''}"
                    />
                      <ErrorMessage name="title" class="error-message"  />
                  </div>
                  <!-- end title -->
                  <!-- description -->
                  <div class="col-span-2">
                    <label for="about" class=" text-sm font-medium text-gray-700">
                      وصف الاستبيان
                  </label>
                  </div>
                  <div class="col-span-10">
                    <Field type="textarea" id="description" name="description" rows="3" v-model="model.description"
                                autocomplete="survey_description"
                                class="keyword-input with-border"
                                placeholder="وصف الاستبيان" />

                      <ErrorMessage name="description" class="error-message" />
                  </div>
                  <!-- end description -->
                  <!-- EndDate -->
                  <div class="col-span-2">
                    <label for="expire_date" class=" text-sm font-medium text-gray-700">تاريخ الاستبيان</label>
                  </div>
                  <div class=" block col-span-10">
                      <Field name="expire_date" :validateOnInput="true" :validateOnChange="true" :value="model.expire_date" v-slot="{  handleChange }">
                              <custom-date-picker

                                          locale="en"
                                          @update:modelValue="handleChange"
                                          :modelValue="model.expire_date"
                                          id="expire_date"
                                          v-model="model.expire_date"
                                          class="shadow-none with-border "

                              />
                      </Field>
                      <!--                                          :class="{'invalid-input':errors.expire_date??''}"-->

                      <div>
                      <ErrorMessage name="expire_date" class="error-message" />
                    </div>
                  </div>
<!--                  end EndDate -->
                  <!-- status -->
<!--                  <div class="col-span-2">-->
<!--                    <label for="status" class="font-medium text-gray-700">الحالة</label>-->
<!--                  </div>-->
<!--                  <div class="col-span-10">-->
<!--                    <div class="flex items-center h-5">-->
<!--                      <input id="stats" name="status" type="checkbox" v-model="model.status"-->
<!--                          class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" />-->
<!--                  </div>-->
<!--                  </div>-->
                  <!--end status -->
                  <div class="col-span-2 mt-2">
                    <h3 class="text-2xl font-semibold flex items-center justify-between">
                      الاسئلة
                      </h3>
                  </div>
                  <div class="col-span-10"></div>
                  <div class="col-span-2">
                    <button type="button" @click="addQuestion()"
                            class="flex items-center text-sm py-2 px-4 rounded-sm text-white bg-blue-600 hover:bg-blue-800 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            إضافة سؤال
                        </button>
                  </div>
                  <div class="col-span-10"></div>
                  <div class="col-span-12">
                    <div v-if="!model.questions.length" class="text-center text-gray-600">
                      ليس لديك اي اسئلة بعد
                        <div v-if="!model.questions.length" class="error-message mt-1 mb-2">
                            {{errors['questions']}}
                        </div>
                  </div>
                  <div v-for="(question, index) in model.questions" :key="question.id">
                      <QuestionEditor :question="question" :index="index" @change="questionChange" v-model="question.value" :errors="errors"
                          @addQuestion="addQuestion" @deleteQuestion="deleteQuestion" />
                  </div>

<!--                      <div v-if="Object.keys(errors).length > 0">-->
<!--                          <ul>-->
<!--&lt;!&ndash;                              <li v-for="(fieldErrors, fieldName) in errors" :key="fieldName">&ndash;&gt;-->
<!--&lt;!&ndash;                                  <span>{{ fieldName }}</span>&ndash;&gt;-->
<!--&lt;!&ndash;                                  <span>{{ fieldErrors }}</span>&ndash;&gt;-->

<!--&lt;!&ndash;                              </li>&ndash;&gt;-->
<!--                              <li>-->
<!--                                  <pre>-->
<!--                                      {{errors}}-->
<!--                                  </pre>-->
<!--                              </li>-->
<!--                          </ul>-->
<!--                      </div>-->


                  <div class="col-span-2">
                    <TButton class="mb-4" :disabled="isLoading" v-if="model.questions.length">
                        <div class="ml-3 spinner-border spinner-border-sm text-light spinner-loading"
                             v-if="isLoading"  role="status">
                        </div>
                      <SaveIcon  v-if="!isLoading" class="w-5 h-5 mr-2 " />
                        <span v-if="props.itemId">{{t('update_survey')}}</span>
                        <span v-else>{{t('create_survey')}}</span>

                  </TButton>

<!--                      <button class="btn mb-4" @click="testValidationSchema()"  type="button">-->

<!--                          <SaveIcon  v-if="!isLoading" class="w-5 h-5 mr-2 " />-->
<!--                                Test validation-->
<!--                      </button>-->

                  </div>
              </div>
                  </div>

                </div>
<!--                    {{props.itemId}}-->
        </Form>
    </PageComponent>
</template>

<script setup>

import { useForm, ErrorMessage ,Field,useFieldError,useFormErrors} from 'vee-validate';
import * as yup from 'yup';
import { v4 as uuidv4 } from "uuid";
import { computed, ref, watch, onMounted, toRefs,reactive ,provide ,getCurrentInstance,inject} from "vue";
// import { useRoute, useRouter } from "vue-router";
import { SaveIcon, TrashIcon, ExternalLinkIcon } from '@heroicons/vue/solid'
import store from "../store";
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/editor/QuestionEditor.vue";
import TButton from "../components/core/TButton.vue";
import { useI18n } from 'vue-i18n';
import messages from '../locale/messages.js';
import moment from 'moment';



const props = defineProps({
    trainingLink: String,
    training_id:String,
    localee:String,
    trainingStartDate:String,
    trainingEndDate:String,
    itemId:String,

});
// const emit = defineEmits(["changeSurveyIdFunction"]);

// x
// multi language label
const {  t,locale,availableLocales} = useI18n({
    inheritLocale: false,
    useScope: "local",
    // locale:props.localee,
    locale:"ar",
    messages
});

// end multi language label
let isLoading = ref(false);
const changeSurvey = inject('rootFunction');


let model = ref({
    title: "",
    slug: "",
    status: false,
    description: null,
    image: null,
    image_url: null,
    expire_date: null,
    questions: [],
    selectedText:"اختر نوع السؤال .."
});
const initialModel = ref({
    title: "",
    slug: "",
    status: false,
    description: null,
    image: null,
    image_url: null,
    expire_date: null,
    questions: [],
    selectedText:"اختر نوع السؤال .."
});

const resetModel = () => {
    Object.assign(model.value, initialModel);
};

function validateImage(value, context) {
    if (!value.type || !value.type.startsWith('image/')) {
        return false;
    }
    return true; // Validation passed
}

const schema = yup.object().shape({
    id:yup.number().nullable(),
    // image:yup.mixed().nullable().test('image', t('survey_image_type'), validateImage),
    image:yup.mixed().nullable(),
    title: yup.string().required(t('title_error_req_msg')),
    expire_date: yup.string()
        .required(t('date_req_msg'))
        .test('is-valid-date', t('date_range_error_msg', {
            attribute: t('survey_date'),
            start_date: props.trainingStartDate,
            end_date: props.trainingEndDate,

        }), value => {
            // Convert the input date string to a Date object
            const expireDate = new Date(value);
            // Define the allowed date range
            const startDate = new Date(props.trainingStartDate);
            const endDate = new Date(props.trainingEndDate);
            // Perform the validation
            return expireDate >= startDate && expireDate <= endDate;
        }),
    questions: yup.array().of(
        yup.object().shape({
            id: yup.string().nullable(),
            type: yup.string().required(t('question_type_req_msg')),
            question: yup.string().required(t('question_error_req_msg')),
            data: yup.object().shape({
                    options: yup.array().of(
                            yup.object().shape({
                                uuid: yup.string().nullable(),
                                text: yup.string().required(t('option_is_required')),
                            })
                        )
                        .min(2,t('at_least_two_option'))
                        .required(t('options_are_required'))
                })
                .nullable(true)
                .default(null),
        })
    ).required(t('question_at_least_one_req'))
});
const instance = getCurrentInstance()
const changeSurveyIdFunction=function(){
    instance?.appContext.config.globalProperties.changeItemId();
}

const { handleSubmit, setFieldValue, values, errors,validate , validateField  } = useForm({

    validationSchema: schema,
    validateOnMount: false,
    // keepValuesOnUnmount:true,
    // initialValues: {...model},
    // validateOnModelUpdate:true,

});


// watch(model, (newModel) => {
//     validate(newModel);
//     console.log(validate(newModel));
// }, { deep: true });
// Initialize new reactive variables

// const userLocale = ref(props.localee);
// watch(userLocale, (newLocale) => {
//     $i18n.locale=newLocale;
//     locale.value = newLocale; // This will change the application's language
// });

// const formSubmitted = ref(false);
//
// const handleSubmit = async (ev) => {
//     ev.preventDefault();
//     formSubmitted.value = true;
//     const isValid = await validate();
//
//     if (isValid) {
//         // Handle form submission
//     }
// };
// Get survey loading state, which only changes when we fetch survey from backend
const surveyLoading = computed(() => store.state.currentSurvey.loading);

// Create empty survey



onMounted(() => {

        if(props.itemId){
            store.dispatch("getSurvey", props.itemId);
        }else{
            addQuestion();
        }
        // console.log(props.trainingStartDate);
}
);
// Watch to current survey data change and when this happens we update local model
watch(
    () => store.state.currentSurvey.data,
    (newVal, oldVal) => {
        model.value = {
            ...JSON.parse(JSON.stringify(newVal)),
            status: !!newVal.status,
        };

    }
);


const rootFunction = inject('rootFunction')
// If the current component is rendered on survey update route we make a request to fetch survey
// if (route.params.id) {
//   store.dispatch("getSurvey", route.params.id);
// }

async  function testValidationSchema(){
    // console.log({...model.value});
    const validatedForm= await validate();
    if(validatedForm.valid){
        schema.validate({...model.value}).then((validData) => {
            // Data is valid
            // console.log(validData);
        }).catch((errors) => {
            // console.log(errors);
            // Validation failed, handle the error
            console.error(errors.message);
        });
    }

}


function onImageChoose(ev) {
    const file = ev.target.files[0];
    // Check if the file is an image based on its MIME type
    if (!file.type.startsWith('image/')) {
        // Display an error message or ignore the file selection
        ev.target.value = ""; // Clear the file input
        model.value.image = ""; // Clear the file input
        model.value.image_url="";
        return;
    }else{
        const reader = new FileReader();
        reader.onload = () => {
            // The field to send on backend and apply validations
            model.value.image = reader.result;

            // The field to display here
            model.value.image_url = reader.result;
            // ev.target.value = "";
        };
        reader.readAsDataURL(file);
    }

}

function addQuestion(index) {
    const newQuestion = {
        id: uuidv4(),
        type: "",
        question: "",
        description: null,
        data: {},
    };
    model.value.questions.push(newQuestion);
    // model.value.questions.splice(index, 0, newQuestion);
}

function deleteQuestion(question) {
    model.value.questions = model.value.questions.filter((q) => q !== question);
}

function questionChange(question) {
    // Important to explicitelly assign question.data.options, because otherwise it is a Proxy object
    // and it is lost in JSON.stringify()
    if (question.data.options) {
        question.data.options = [...question.data.options];
    }
    model.value.questions = model.value.questions.map((q) => {
        if (q.id === question.id) {
            return JSON.parse(JSON.stringify(question));
        }
        return q;
    });

}

/**
 * Create or update survey
 */

const onSubmit = handleSubmit(values => {
    // alert(JSON.stringify(values, null, 2));
    alert(JSON.stringify(values));
});
 async  function saveSurvey(ev) {
    ev.preventDefault();

    //     .then(validatedData => {
    //         console.log(validatedData);
    //         // Validation successful, do something with the data
    //     })
    //     .catch(errors => {
    //         // Validation failed, handle errors
    //         console.log(errors);
    //     });


    const validatedForm= await validate();
    if(validatedForm.valid){

    isLoading.value=true;
    let action = "created";
    if (model.value.id) {
        action = "updated";
    }

    model.value.training_id= props.training_id;
    store.dispatch("saveSurvey", { ...model.value }).then(({ data }) => {

        if (model.value.id) {
            const event = new CustomEvent('myCustomEvent', { detail: {status:true, message: t('success_update_survey') } });
            window.dispatchEvent(event);
        }else{
            const event = new CustomEvent('myCustomEvent', { detail: {status:true, message: t('success_create_survey') } });
            window.dispatchEvent(event);
        }
        isLoading.value=false;

        // console.log(this.renderComponent.value);

        rootFunction();

    }).catch(()=>{
        isLoading.value=false;
    });
    }
}

function deleteSurvey() {
    if (
        confirm(
            `Are you sure you want to delete this survey? Operation can't be undone!!`
        )
    ) {
        store.dispatch("deleteSurvey", model.value.id).then(() => {
            router.push({
                name: "Surveys",
            });
        });
    }
}
</script>

<style>
.error-message{
    color:red;
}
.invalid-input{
    border:1px solid red !important;
}
.vpd-icon-btn{
     margin-bottom: 0px !important;
}
</style>
