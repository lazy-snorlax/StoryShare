import type { Component } from "vue";
import AppTemplate from './AppTemplate.vue'
import AuthTemplate from './AuthTemplate.vue'
import AdminTemplate from "./AdminTemplate.vue";

export type TemplateKeys = 'app' | 'auth' | 'admin'

export const templates: { [key in TemplateKeys]: Component } = {
    app: AppTemplate,
    auth: AuthTemplate,
    admin: AdminTemplate,
}