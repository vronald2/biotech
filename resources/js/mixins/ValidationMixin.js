import Vue from 'vue';
import { mapGetters } from 'vuex';

const Validation = {
  install(Vue, options) {
    Vue.mixin({
      computed: {
        ...mapGetters({
          validationMessages: 'validation/validationErrorMessages',
          validationStates: 'validation/validationErrorStates',
          validationFailed: 'validation/invalid'
        })
      }
    });
  }
};

Vue.use(Validation);
