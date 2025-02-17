import { createRouter, createWebHistory } from 'vue-router';
import landingPage from '../components/landingpage.vue';
import botiga from '../components/botiga.vue';
import empreses from '../components/empreses.vue';
import quiSom from '../components/quiSom.vue';
import login from '../components/login.vue';
import register from '../components/register.vue';
import novaEmpresa from '../components/novaEmpresa.vue';
import EditaEmpresa from '../components/EditaEmpresa.vue';
import dashboard from '../components/dashboard.vue';
import NouProducte from '../components/NouProducte.vue';
import editaProducte from '../components/editaProducte.vue';






const routes = [
  {
    path: '/',
    name: 'landingpage',
    component: landingPage
  },
  {
    path: '/botiga',
    name: 'botiga',
    component: botiga
  },
  {
    path: '/empreses',
    name: 'empreses',
    component: empreses
  },
  {
    path: '/qui-som',
    name: 'quisom',
    component: quiSom
  },
  {
    path: '/login',
    name: 'login',
    component: login
  },
  {
    path: '/register',
    name: 'register',
    component: register
  },
  {
    path: '/novaEmpresa',
    name: 'novaEmpresa',
    component: novaEmpresa
  },
  {
    path: '/EditaEmpresa',
    name: 'EditaEmpresa',
    component: EditaEmpresa
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: dashboard
  },
  {
    path: '/NouProducte',
    name: 'NouProducte',
    component: NouProducte
  },
  {
    path: '/editaProducte',
    name: 'editaProducte',
    component: editaProducte
  }
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
});

export default router;
