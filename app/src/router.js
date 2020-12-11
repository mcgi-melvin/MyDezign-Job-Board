import VueRouter from 'vue-router'

import JobList from './components/JobList.vue'
import JobAdd from './components/JobAdd.vue'
import JobSingle from './components/JobSingle.vue'
import Disclaimer from './components/Disclaimer.vue'

const routes = [
    {
        name: 'home',
        path: '/',
        component: JobList
    },
    {
        name: 'job_add',
        path: '/add',
        component: JobAdd
    },
    {
        name: 'job_single',
        path: '/job/:id',
        component: JobSingle
    },
    {
        name: 'disclaimer',
        path: '/disclaimer',
        component: Disclaimer
    }
]
  
const router = new VueRouter({
    routes, // short for `routes: routes`
})
/*
router.beforeEach((to, from, next) => {
    console.log(to)
    console.log(from)
    console.log(next)
})
*/

export default router