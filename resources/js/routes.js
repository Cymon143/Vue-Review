import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
const routes = [
    {
        path:'*',
        name:'not-found',
        component: require('./components/NotFound.vue').default
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: require('./components/Dashboard.vue').default,
    },
    {
        path: '/profile',
        name: 'profile',
        component: require('./components/Profile.vue').default
    },
    //---------------------------------------------------------USER
    {
        path: '/users',
        name: 'users',
        component: require('./components/Users/IndexUser.vue').default,
        props: true,
    },
    //---------------------------------------------------------END USER
    //---------------------------------------------------------ROLE
    {
        path: '/role',
        name: 'role',
        component: require('./components/Role/IndexRole.vue').default,
        props: true,
    },
    // {
    //     path: '/role-add/:page',
    //     name: 'role_add',
    //     component: require('./components/Role/AddRole.vue').default,
    //     props: true,
    // },
    //---------------------------------------------------------END ROLE
    //---------------------------------------------------------PERMISSION
    {
        path: '/permission',
        name: 'permission',
        component: require('./components/Permission/IndexPermission.vue').default
    },
    // {
    //     path: '/permission-add',
    //     name: 'permission-add',
    //     component: require('./components/Permission/AddPermission.vue').default
    // },
    //---------------------------------------------------------END PERMISSION
    //---------------------------------------------------------REGISTRAR
    {
        path: '/registrar',
        name: 'registrar',
        component: require('./components/Registrar/IndexRegistrar.vue').default
    },
    //---------------------------------------------------------END REGISTRAR
    //---------------------------------------------------------PROGRAM
    {
        path: '/program',
        name: 'program',
        component: require('./components/Program/IndexProgram.vue').default
    },
    //---------------------------------------------------------END PROGRAM
    //---------------------------------------------------------MAJOR
    {
        path: '/major',
        name: 'major',
        component: require('./components/Major/IndexMajor.vue').default
    },
    //---------------------------------------------------------END MAJOR
    //---------------------------------------------------------SUBJECT
    {
        path: '/subject',
        name: 'subject',
        component: require('./components/Subject/IndexSubject.vue').default
    },
    //---------------------------------------------------------END SUBJECT
    //---------------------------------------------------------SECTION
    {
        path: '/section',
        name: 'section',
        component: require('./components/Section/IndexSection.vue').default
    },
    //---------------------------------------------------------END SECTION
    //---------------------------------------------------------SECTION
    {
        path: '/schedule',
        name: 'schedule',
        component: require('./components/Schedule/IndexSchedule.vue').default
    },
    //---------------------------------------------------------END SECTION
    //---------------------------------------------------------LEVEL SUBJECT
    {
        path: '/level-subject',
        name: 'level_subject',
        component: require('./components/LevelSubject/IndexLevelSubject.vue').default
    },
    //---------------------------------------------------------END LEVEL SUBJECT
    //---------------------------------------------------------LEVEL SUBJECT
    {
        path: '/substitution',
        name: 'substitution',
        component: require('./components/Substitution/IndexSubstitution.vue').default
    },
    //---------------------------------------------------------END LEVEL SUBJECT
    //---------------------------------------------------------LEVEL SUBJECT
    {
        path: '/settings',
        name: 'settings',
        component: require('./components/Settings.vue').default
    },
    //---------------------------------------------------------END LEVEL SUBJECT
    //---------------------------------------------------------LEVEL SUBJECT
    {
        path: '/schedule-search',
        name: 'schedule-search',
        component: require('./components/ScheduleSearch/IndexScheduleSearch.vue').default
    },
    //---------------------------------------------------------END LEVEL SUBJECT
    //---------------------------------------------------------TEACHER LOAD
    {
        path: '/teacher-load',
        name: 'teacher-load',
        component: require('./components/TeacherLoad/IndexTeacherLoad.vue').default
    },
    //---------------------------------------------------------END TEACHER LOAD
]
// Vue.component(
//     'enrollment-status',
//     require('./components/EnrollmentStatus.vue').default
// );
const router = new Router({
	mode: 'history',
	routes: routes
});

export default router
