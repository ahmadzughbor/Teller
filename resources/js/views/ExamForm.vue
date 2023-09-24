<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{"إنشاء اختبار جديد" }}
                </h1>
                <div class="flex">
                </div>
            </div>
        </template>

        <form  @submit.prevent="saveSurvey"  :validation-schema="schema" class="animate-fade-in-down"  :key="componentKey" >
            <div class=" sm:rounded-md sm:overflow-hidden">
                <!-- Survey Fields -->
                <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                    <!-- Image -->
                    <div class="grid grid-cols-12 gap-y-2 items-center px-5">
                        <div class="col-span-2">
                            <label class="block al text-sm font-medium text-gray-700">
                                صورة الاختبار
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
                                        class="relative overflow-hidden ml-5  bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm  font-medium text-gray-700 ">


                                    <Field type="file"  name="image" @change="onImageChoose" accept="image/*"
                                           class="absolute left-0 top-0 right-0 bottom-0 opacity-0  cursor-pointer" style="display: -webkit-box"  />
                                    تغيير
                                </button>
                            </div>
                            <ErrorMessage name="image" class="error-message mt-1"  />
                        </div>


                        <div class="col-span-2">
                            <label for="title" class="text-sm font-medium text-gray-700">{{t('survey_title')}}</label>
                        </div>
                        <div class="col-span-10">
                            <Field type="text" name="title" id="title" placeholder="عنوان الاختبار" v-model="model.title" autocomplete="survey_title"
                                   class="keyword-input with-border"
                                   :class="{'invalid-input':errors.title??''}"
                            />
                            <ErrorMessage name="title" class="error-message"  />
                        </div>



                        <div class="col-span-2">
                            <label for="about" class=" text-sm font-medium text-gray-700">
                                وصف الاختبار
                            </label>
                        </div>
                        <div class="col-span-10">
                            <Field type="textarea" id="description" name="description" rows="3" v-model="model.description"
                                   autocomplete="survey_description"
                                   class="keyword-input with-border"
                                   placeholder="وصف الاختبار" />

                            <ErrorMessage name="description" class="error-message" />
                        </div>

                        <div class="col-span-2">
                            <label for="expire_date" class=" text-sm font-medium text-gray-700">تاريخ الاختبار</label>
                        </div>
                        <div class=" block col-span-10">
                            <Field name="expire_date" :validateOnInput="true" :validateOnChange="true" :value="model.expire_date" v-slot="{  handleChange }">

                                <custom-date-picker
                                    locale="en"
                                    @update:modelValue="handleChange"
                                    :modelValue="model.expire_date"
                                    id="expire_date"
                                    :value="model.expire_date"
                                    v-model="model.expire_date"
                                    class="shadow-none with-border "
                                />

                            </Field>
                            <!--                                          :class="{'invalid-input':errors.expire_date??''}"-->

                            <div>

                                <ErrorMessage name="expire_date" class="error-message" />
                            </div>
                        </div>
                    </div>



                </div>
                <!--/ Survey Fields -->

                <div class="col-span-2">
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
                        <QuestionEditor :question="question"
                                        :index="index"
                                        @change="questionChange"
                                        v-model="question.value"
                                        :errors="errors"
                                        @addQuestion="addQuestion"
                                        @deleteQuestion="deleteQuestion" />
                    </div>


                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <TButton :disabled="isLoading" v-if="model.questions.length">
                        <div class="ml-3 spinner-border spinner-border-sm text-light spinner-loading"
                             v-if="isLoading"  role="status">
                        </div>
                        <SaveIcon  v-if="!isLoading" class="w-5 h-5 mr-2 " />
                        <span v-if="props.examId">{{t('update_exam')}}</span>
                        <span v-else>{{t('create_exam')}}</span>

                    </TButton>
                </div>
            </div>
            </div>
        </form>
    </PageComponent>
</template>

<script setup>

import { useForm, ErrorMessage ,Field,useFieldError,useFormErrors} from 'vee-validate';
import * as yup from 'yup';
import {defineProps, nextTick} from 'vue';
import { v4 as uuidv4 } from "uuid";
import { computed, ref, watch,onMounted } from "vue";
import { SaveIcon, TrashIcon, ExternalLinkIcon } from '@heroicons/vue/solid'
import store from "../store";
import PageComponent from "../components/PageComponent.vue";
import QuestionEditor from "../components/editor/QuestionEditorExam.vue";
import TButton from "../components/core/TButton.vue";
import { useI18n } from 'vue-i18n';
import messages from '../locale/messages.js';

const props = defineProps({
    lessonId: String,
    lessonLink:String,
    localee:String,
    examId:String,
    courseId:String,
});
// handle localization
const {  t,locale,availableLocales} = useI18n({
    inheritLocale: false,
    useScope: "local",
    locale:props.localee,
    messages
});
let isLoading = ref(false);
// Get survey loading state, which only changes when we fetch survey from backend
const surveyLoading = computed(() => store.state.currentSurvey.loading);
const componentKey = ref(0);
// Create empty survey
let model = ref({
    title: "",
    slug: "",
    status: false,
    description: null,
    image: null,
    image_url: null,
    expire_date: null,
    questions: [],
    lesson_id:null,
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
    lesson_id:null,
    selectedText:"اختر نوع السؤال .."

});

onMounted(() => {

    if(props.examId){
        store.dispatch("getExam", props.examId);

    }else{
        addQuestion();
        questionChange(model.value.questions[0]);
    }

});

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

// If the current component is rendered on survey update route we make a request to fetch survey
// if (route.params.id) {
//     store.dispatch("getSurvey", route.params.id);
// }

function validateImage(value, context) {
    if (!value.type || !value.type.startsWith('image/')) {
        return false;
    }
    return true; // Validation passed
}

const schema = yup.object().shape({
    // image:yup.mixed().required(t('survey_image_req')).test('image', t('survey_image_type'), validateImage),
    image:yup.mixed().nullable(),
    title: yup.string().required(t('title_error_req_msg')),
    expire_date: yup.string().required(t('date_req_msg')).test('is-valid-date', t('date_req_msg'), function (value) {
            // Parse the expire_date and compare it with the current date
            const currentDate = new Date();
            const selectedDate = new Date(value);

            // Return true if the selectedDate is equal to or greater than the current date
            return selectedDate >= currentDate;
        }),
    questions: yup.array().of(
        yup.object().shape({
            id: yup.string().nullable(),
            mark: yup.string().required(t('question_mark_req_msg')),
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

const { handleSubmit, setFieldValue, values, errors,validate , validateField  } = useForm({

    validationSchema: schema,
    validateOnMount: false,
    // keepValuesOnUnmount:true,
    // initialValues: {...model.value},
    validateOnModelUpdate:true,

});
// expire_date: yup.string()
//     .required(t('date_req_msg'))
//     .test('is-valid-date', t('date_range_error_msg', {
//         attribute: t('survey_date'),
//         start_date: props.trainingStartDate,
//         end_date: props.trainingEndDate,
//
//     }), value => {
//         // Convert the input date string to a Date object
//         const expireDate = new Date(value);
//         // Define the allowed date range
//         const startDate = new Date(props.trainingStartDate);
//         const endDate = new Date(props.trainingEndDate);
//         // Perform the validation
//         return expireDate >= startDate && expireDate <= endDate;
//     }),
function onImageChoose(ev) {
    const file = ev.target.files[0];

    const reader = new FileReader();
    reader.onload = () => {
        // The field to send on backend and apply validations
        model.value.image = reader.result;

        // The field to display here
        model.value.image_url = reader.result;
        ev.target.value = "";
    };
    reader.readAsDataURL(file);
}

function addQuestion(index) {
    const newQuestion = {
        id: uuidv4(),
        type: null,
        mark: null,
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


const resetModel = () => {
    Object.assign(model.value, initialModel);
};



/**
 * Create or update survey
 */
async function saveSurvey(ev) {
    ev.preventDefault();

    const validatedForm= await validate();
    if(validatedForm.valid){
        isLoading.value=true;
        let action = "created";
        if (model.value.id) {
            action = "updated";
        }
        model.value.lesson_id= props.lessonId;
        model.value.course_id= props.courseId;
        store.dispatch("saveTaskExam", { ...model.value }).then(({ data }) => {
            const event = new CustomEvent('myCustomEvent', { detail: {status:true, message: 'Hello!' } });
            window.dispatchEvent(event);
            isLoading.value=false;

            // console.log(data);
            // componentKey.value++;
            // resetModel();
            // model.value.image_url="";
            // model.value.expire_date=null;
            // model.value.questions=[];

            window.location.href=props.lessonLink;
        }).catch(()=>{
            isLoading.value=false;
        });
    }
}
function deleteSurvey() {
    if (confirm(`Are you sure you want to delete this survey? Operation can't be undone!!`)) {
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
