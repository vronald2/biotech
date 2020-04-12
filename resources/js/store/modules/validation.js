import { Module, VuexModule, Mutation, Action } from "vuex-module-decorators";
import {forEach, size} from 'lodash';

@Module({
  stateFactory: true,
  namespaced: true
})
export default class ValidationModule extends VuexModule {
  errors = {};

  get validationErrorMessages() {
    let errors = {};
    forEach(this.errors, (messages, field) => {
      errors[field] = messages[0];
    });

    return errors;
  }

  get validationErrorStates() {
    let errors = {};
    forEach(this.errors, (messages, field) => {
      errors[field] = messages && messages.length > 0 ? false : null;
    });

    return errors;
  }

  get invalid() {
    return size(this.errors) > 0
  }

  @Mutation
  setValidationErrors(errors) {
    this.errors = errors;
  }

  @Action({commit: 'setValidationErrors'})
  setErrors(errors) {
    return errors;
  }

  @Action({commit: 'setValidationErrors'})
  clearErrors() {
    return {};
  }
}
