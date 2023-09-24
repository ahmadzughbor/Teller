<template>
  <!-- Question index -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg font-bold">
      {{ index + 1 }}. {{ model.question }}
    </h3>


    <div class="flex items-center">
      <!-- Add new question -->
      <button
        type="button"
        @click="addQuestion()"
        class="
          flex
          items-center
          text-xs
          py-2
          px-4
          mr-2
          rounded-md
          text-white
          bg-blue-700  bg-blue-800
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
            clip-rule="evenodd"
          />
        </svg>
        اضافة
      </button>
      <!--/ Add new question -->

      <!-- Delete question -->
      <button
        type="button"
        @click="deleteQuestion()"
        class="
          flex
          items-center
          text-xs
          py-1
          px-3
          rounded-sm
          border border-transparent
          text-red-500
          hover:border-red-600
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          viewBox="0 0 20 20"
          fill="currentColor"
        >
          <path
            fill-rule="evenodd"
            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
            clip-rule="evenodd"
          />
        </svg>
        حذف
      </button>
      <!--/ Delete question -->
    </div>
  </div>
  <!--/ Question index -->
  <div class="grid gap-3 grid-cols-12">
    <!-- Question -->
    <div class="mt-3 col-span-8">
      <label :for="'question_text_' + model.data" class="block text-sm font-medium text-gray-700">
          سؤال الاستبيان
      </label>
      <Field
        type="text"
        :name="`questions[`+index+`].question`"
        v-model="model.question"
        @change="dataChange"
        :id="'question_text_' + model.data"
        class="keyword-input with-border"
        placeholder="سؤال الاستبيان"
        :class="{'invalid-input':childErrors[`questions[`+index+`].question`]??''}"
      />
        <ErrorMessage :name="`questions[`+index+`].question`" class="error-message" />
    </div>
    <!--/ Question -->

    <!-- Question Type -->
    <div class="mt-3 col-span-4">
      <label for="question_type" class="block text-sm font-medium text-gray-700"
        >اختيار نوع السؤال</label
      >
    <div class="relative">
        <div class="border border-solid border-gray-300 rounded-md py-2 flex flex-row justify-between items-center px-2 cursor-pointer" :class="{'invalid-input':childErrors[`questions[`+index+`].type`]??''}">
        <div class="text-muted divSelection">{{selectedText}} </div>

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg>
        </div>
      </div>
      <div class="bg-white w-100 shadow-lg border border-gray-100 p-2 mt-12 rounded-md text-gray-500 hidden text-left font-medium uk-drop uk-drop-bottom w-full" uk-drop="pos: bottom; mode:click">


          <ul class="space-y-1">
                            <!-- radio -->
                                <li class=" flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md cursor-pointer uk-drop-close" @click="selectedQuestionType('radio')" >
                                    <label class="">
                                        <Field type="radio"
                                               :name="`questions[`+index+`].type`"
                                               hidden
                                               v-model="model.type"
                                               value="radio"
                                               id="radio-btn-1"   />
                                        <label class="flex flex-row gap-2 items-center cursor-pointer" for="radio-btn-1">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" class="text-lg" fill="rgb(79,70,229)" height="1em" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-352a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg></span>
                                            <span>اختر</span>
                                        </label>
                                    </label>
                                </li>


                                <li class=" flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md cursor-pointer uk-drop-close"  @click="selectedQuestionType('checkbox')">
                                    <label class="">
                                        <Field type="radio"  hidden
                                               :name="`questions[`+index+`].type`"
                                               value="checkbox"
                                               v-model="model.type"
                                                id="multi-choice" />
                                        <label for="multi-choice" class="flex flex-row gap-2 items-center cursor-pointer">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" class="text-lg" fill="rgb(79,70,229)" height="1em" viewBox="0 0 448 512"><path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H384c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H384c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zM337 209L209 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L303 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg></span>
                                            <span>خيار متعدد</span>
                                        </label>
                                    </label>
                                </li>
                                <li class=" flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md cursor-pointer uk-drop-close" @click="selectedQuestionType('text')">
                                    <label class="">
                                        <Field type="radio"  hidden
                                               :name="`questions[`+index+`].type`"
                                               value="text"
                                               v-model="model.type"
                                               id="text-choice"
                                        />
                                        <label for="text-choice" class="flex flex-row gap-2 items-center cursor-pointer">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" class="text-lg" height="1em" fill="rgb(79,70,229)" viewBox="0 0 512 512"><path d="M64 144a48 48 0 1 0 0-96 48 48 0 1 0 0 96zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM64 464a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm48-208a48 48 0 1 0 -96 0 48 48 0 1 0 96 0z"/></svg></span>
                                            <span>نص</span>
                                        </label>
                                    </label>
                                </li>

                                <li class=" flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md cursor-pointer uk-drop-close" @click="selectedQuestionType('select')">
                                    <label class="">
                                        <Field type="radio"  hidden
                                               :name="`questions[`+index+`].type`"
                                               value="select"
                                               id="select-choice"
                                               v-model="model.type" />
                                        <label for="select-choice" class="flex flex-row gap-2 items-center cursor-pointer">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" class="text-lg" fill="rgb(79,70,229)" height="1em" viewBox="0 0 512 512"><path d="M152.1 38.2c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 113C-2.3 103.6-2.3 88.4 7 79s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zm0 160c9.9 8.9 10.7 24 1.8 33.9l-72 80c-4.4 4.9-10.6 7.8-17.2 7.9s-12.9-2.4-17.6-7L7 273c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l22.1 22.1 55.1-61.2c8.9-9.9 24-10.7 33.9-1.8zM224 96c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H256c-17.7 0-32-14.3-32-32zM160 416c0-17.7 14.3-32 32-32H480c17.7 0 32 14.3 32 32s-14.3 32-32 32H192c-17.7 0-32-14.3-32-32zM48 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg></span>
                                            <span>قائمة منسدلة</span>
                                        </label>
                                    </label>
                                </li>
                                <li class=" flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md cursor-pointer uk-drop-close" @click="selectedQuestionType('textarea')">
                                    <label class="">
                                        <Field type="radio"  hidden
                                               :name="`questions[`+index+`].type`"
                                               value="textarea"
                                               v-model="model.type"
                                               id="textarea-choice"
                                        />
                                        <label for="textarea-choice" class="flex flex-row gap-2 items-center cursor-pointer">
                                            <span><svg xmlns="http://www.w3.org/2000/svg" class="text-lg" fill="rgb(79,70,229)" height="1em" viewBox="0 0 576 512"><path d="M64 80c-8.8 0-16 7.2-16 16V416c0 8.8 7.2 16 16 16H512c8.8 0 16-7.2 16-16V96c0-8.8-7.2-16-16-16H64zM0 96C0 60.7 28.7 32 64 32H512c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96zm96 64a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zm104 0c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm0 96c0-13.3 10.7-24 24-24H448c13.3 0 24 10.7 24 24s-10.7 24-24 24H224c-13.3 0-24-10.7-24-24zm-72-64a32 32 0 1 1 0-64 32 32 0 1 1 0 64zM96 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/></svg></span>
                                            <span>مساحة نصية</span>
                                        </label>
                                    </label>
                                </li>
                            </ul>
         </div>


        <ErrorMessage :name="`questions[`+index+`].type`" class="error-message" />
    </div>
      <!-- <select
        id="question_type"
        name="question_type"
        v-model="model.type"
        @change="typeChange"
        class="
        keyword-input with-border
        "
      style="padding: 0.25rem;"
      >

        <option v-for="type in questionTypes" :key="type" :value="type">
          {{ upperCaseFirst(type) }}
        </option>
      </select> -->
    </div>
    <!--/ Question Type -->
  </div>

  <!-- Question Description -->
  <div class="mt-3 col-span-9">
    <label
      :for="'question_description_' + model.id"
      class="block text-sm font-medium text-gray-700"
      >وصف السؤال</label
    >
    <textarea
      :name="'question_description_' + model.id"
      v-model="model.description"
      @change="dataChange"
      :id="'question_description_' + model.id"
      class="
      keyword-input with-border
      "
      placeholder="وصف السؤال"
    />
  </div>
  <!--/ Question Description -->
<!--    <pre>{{childErrors}}</pre>-->
  <!-- Data -->
  <div>
    <div v-if="shouldHaveOptions()" class="my-2 py-2">
      <h4 class="text-sm font-semibold mb-3 flex justify-between items-center">
        الخيارات
        <!-- Add new option -->
        <button
          type="button"
          @click="addOption()"
          class="
            flex
            items-center
            text-xs
            py-2
            px-4
            rounded-md
            text-white
           bg-blue-700 hover:bg-blue-800

          "
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4"
            viewBox="0 0 20 20"
            fill="currentColor"
          >
            <path
              fill-rule="evenodd"
              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
              clip-rule="evenodd"
            />
          </svg>
          إضافة اجابة جديدة
        </button>
        <!--/ Add new option -->
      </h4>

      <div
        v-if="!model.data.options.length"
        class="text-xs text-gray-600 text-center py-3"
      >
        ليس لديك اجابات بعد
      </div>

      <!-- Option list -->
      <div
        v-for="(option, indx) in model.data.options"
        :key="option.uuid"
        class="flex items-center mb-2 ml-20"
      >
        <span class="w-6 text-sm"> {{ indx + 1 }}. </span>
          <div class="w-9/12">
        <Field
          type="text"
          tabindex="1"
          :name="`questions[`+index+`].data.options[`+indx+`].text`"
          v-model="option.text"
          @change="dataChange"
          class="keyword-input with-border"
          placeholder="كتابة الخيار هنا"
          style="margin:0 !important"
          :class="{'invalid-input':childErrors[`questions[`+index+`].data.options[`+indx+`].text`]??''}"
        />


            <ErrorMessage  :name="`questions[`+index+`].data.options[`+indx+`].text`" class="error-message" />
        </div>

        <!-- Delete Option -->
          <div>
                  <button type="button" @click="removeOption(option)" class="flex items-center text-xs py-1 px-3 rounded-sm  border-red-500  text-red-500 hover:border-red-700"><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> حذف </button>
          </div>
        <!-- <button
          type="button"
          @click="removeOption(option)"
          class="
            bg-red-400
            h-6
            w-6
            rounded-full
            flex
            items-center
            justify-center
            border border-transparent
            transition-colors
            hover:border-red-100
          "
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-3 w-3 text-red-500"
            viewBox="0 0 20 20"
            fill="text-red-500"
          >
            <path
              fill-rule="evenodd"
              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
              clip-rule="evenodd"
            />
          </svg>
          حذف
        </button> -->
        <!--/ Delete Option -->
      </div>
       <div class="text-center mt-1">
           <div v-if="childErrors['questions['+index+'].data.options']">
               <ErrorMessage  :name="`questions[`+index+`].data.options`" class="error-message" />
           </div>

       </div>
      <!--/ Option list -->
    </div>
  </div>
  <!--/ Data -->

  <hr class="my-4" />
</template>

<script setup>
import {  Field,ErrorMessage} from 'vee-validate';
import { v4 as uuidv4 } from "uuid";
import { computed, ref} from "@vue/reactivity";
import {watchEffect, watch, onMounted} from "vue";

import store from "../../store";

const selectedText = ref('اختر نوع السؤال ..');

const props = defineProps({
  question: Object,
  errors:Object,
  index: Number,
});




const childErrors = ref(props.errors);
// Re-create the whole question data to avoid unintentional reference change
const model = ref(JSON.parse(JSON.stringify(props.question)));
// Watch for changes to the prop using watchEffect
watchEffect(() => {
    childErrors.value = props.errors;
    model.value = JSON.parse(JSON.stringify(props.question));
});

onMounted(() => {
    if(model.value.type){
        changeQuestionTypeLabel(model.value.type);
    }
});
// watch(
//     () => model.value.type,
//     (newVal, oldVal) => {
//         console.log('type changed from', oldVal, 'to', newVal)
//         // Handle the change here
//     }
// )
const emit = defineEmits(["change", "addQuestion", "deleteQuestion"]);

const questionText = computed(() => `questions.${props.index}.question`);
// const { questionError } = useField(questionText.value, 'required');




// Get question types from vuex
const questionTypes = computed(() => store.state.questionTypes);

function upperCaseFirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

function getOptions() {
  return model.value.data.options;
}

function setOptions(options) {
  model.value.data.options = options;
}

// Check if the question should have options
function shouldHaveOptions() {
  return ["select", "radio", "checkbox"].includes(model.value.type);
}

// Add option
function addOption() {
  setOptions([
    ...getOptions(),
    { uuid: uuidv4(), text: "" },
  ]);
  dataChange();
}

// Remove option
function removeOption(op) {
  setOptions(getOptions().filter((opt) => opt !== op));
  dataChange();
}

// function typeChange() {
//   if (shouldHaveOptions()) {
//     setOptions(getOptions() || []);
//       addOption();
//   }
//   // dataChange();
// }

// Emit the data change
function dataChange() {
  const data = model.value;
  if (!shouldHaveOptions()) {
    delete data.data.options;
  }

  emit("change", data);
}

function addQuestion() {
  emit("addQuestion", props.index + 1);
}

function deleteQuestion() {
  emit("deleteQuestion", props.question);
}
function selectedQuestionType(item){
    model.value.type=item;
    if (shouldHaveOptions()) {

        setOptions(getOptions() || []);
        addOption();
        addOption();
    }
    dataChange();
    changeQuestionTypeLabel(item);

}

function changeQuestionTypeLabel(item){
    switch (item){
        case "text":
            selectedText.value ="نص";
            break;
        case "radio":
            selectedText.value ="إختر ";
            break;
        case "select":
            selectedText.value ="قائمة منسدلة";
            break;
        case "textarea":
            selectedText.value ="مساحة نصية";
            break;
        case "checkbox":
            selectedText.value ="خيارات متعددة";
            break;
    }

}
</script>


<style></style>
