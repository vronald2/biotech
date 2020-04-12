import Vuex from 'vuex';
import Vue from 'vue';
import validation from './modules/validation';

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        validation
    }
});
