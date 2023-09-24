// eventBus.js
import { reactive, readonly } from 'vue';

const eventBus = reactive({});

export function emitEvent(eventName, eventData) {
    eventBus[eventName] = eventData;
}

export function onEvent(eventName, callback) {
    return readonly(eventBus)[eventName]?.watch(callback);
}
