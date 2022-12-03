import { createRouter, createWebHashHistory } from 'vue-router'
import PromptGenerator from '@/views/PromptGenerator.vue'
import SavedPrompt from '@/views/SavedPrompt.vue'
import AccountManage from '@/views/AccountManager.vue'
import TermsOfUse from '@/views/TermsOfUse.vue'
import PrivacyPolicy from '@/views/PrivacyPolicy.vue'
const routes = [
    {
        path: '/',
        name: 'generator',
        component: PromptGenerator,
    },
    {
        path: '/saves',
        name: 'saves',
        component: SavedPrompt,
    },
    {
        path: '/login',
        name: 'login',
        component: AccountManage,
    },
    {
        path: '/register',
        name: 'register',
        component: AccountManage,
    },
    {
        path: '/terms_of_use',
        name: 'terms_of_use',
        component: TermsOfUse,
    },
    {
        path: '/privacy_policy',
        name: 'privacy_policy',
        component: PrivacyPolicy,
    },
]

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    routes,
})

export default router
