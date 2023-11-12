import type { Component } from "vue";
import AppTemplate from './AppTemplate.vue'

export type TemplateKeys = 'app' //| 'auth'

export const templates: { [key in TemplateKeys]: Component } = {
    app: AppTemplate,
    // auth: null
}