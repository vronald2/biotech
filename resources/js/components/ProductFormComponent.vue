<template>
    <div>
        <b-breadcrumb :items="items"></b-breadcrumb>

        <b-tabs content-class="mt-3">
            <b-tab title="Nyelv független paraméterek" active>
                <b-form-group :invalid-feedback="validationMessages.file" label="Termék kép:">
                <b-form-file
                    v-model="form.data.file"
                    :state="validationStates.file"
                    :disabled="form.busy"
                    placeholder="Válassz egy fájlt vagy húzd ide "
                    drop-placeholder="Dobd ide a fájlt"
                ></b-form-file>
                </b-form-group>
                <div class="row">
                    <div class="col-md-6">
                        <b-form-group :invalid-feedback="validationMessages.publish_start" label="Publikálás kezdete:">
                            <b-form-datepicker :state="validationStates.publish_start" :disabled="form.busy" v-model="form.data.publish_start" class="mb-2"></b-form-datepicker>
                        </b-form-group>
                    </div>
                    <div class="col-md-6">
                        <b-form-group :invalid-feedback="validationMessages.publish_end" label="Publikálás vége:">
                            <b-form-datepicker :state="validationStates.publish_end" :disabled="form.busy" v-model="form.data.publish_end" class="mb-2"></b-form-datepicker>
                        </b-form-group>
                    </div>
                </div>

                <b-form-group  label="Címkék:">
                    <b-form-tags input-id="tags-basic" v-model="form.data.tags" class="mb-2"></b-form-tags>
                </b-form-group>
            </b-tab>
            <b-tab title="Angol">
                <b-form-group :invalid-feedback="validationMessages.name_en" label="Név  (angol):">
                    <b-form-input v-model="form.data.name_en"  :state="validationStates.name_en" :disabled="form.busy" ></b-form-input>
                </b-form-group>
                <b-form-group :invalid-feedback="validationMessages.price_en" label="Ár (USD):">
                    <b-form-input v-model="form.data.price_en"  :state="validationStates.price_en" :disabled="form.busy"></b-form-input>
                </b-form-group>
                <b-form-group :invalid-feedback="validationMessages.description_en" label="Leírás (angol):">
                    <ckeditor  v-model="form.data.description_en" ></ckeditor>
                    </b-form-group>
                </b-tab>
            <b-tab title="Magyar">
                <b-form-group :invalid-feedback="validationMessages.name_hu"  label="Név (magyar):">
                    <b-form-input v-model="form.data.name_hu"  :state="validationStates.name_hu" :disabled="form.busy" ></b-form-input>
                </b-form-group>
                <b-form-group :invalid-feedback="validationMessages.price_hu" label="Ár (huf):">
                    <b-form-input v-model="form.data.price_hu"  :state="validationStates.price_hu" :disabled="form.busy"></b-form-input>
                </b-form-group>
                <b-form-group :invalid-feedback="validationMessages.description_hu" label="Leírás (magyar):">
                    <ckeditor v-model="form.data.description_hu"  :state="validationStates.description_hu" :disabled="form.busy"></ckeditor>
                </b-form-group>
            </b-tab>
        </b-tabs>
        <b-button @click="submit()" variant="success">Mentés</b-button>
        <b-button @click="back()" variant="info">Vissza</b-button>

    </div>
</template>

<script>
    import Vue from 'vue';
    import {Component, Prop} from 'vue-property-decorator';
    import moment from 'moment'
    import axios from "axios";

    @Component({})
    export default class ProductCreateFormComponent extends Vue {

        form = null;
        @Prop({type: Object, default: null}) product;

        created() {
            this.resetForm();
            this.items =  [
                {
                    text: 'Termékek',
                    href: '/product'
                },
                {
                    text: this.product?"Termék szerkesztése":"Termék hozzáadása",
                    active: true
                }
            ];
        }

        submit() {

            this.form.busy = true;

            const data = new FormData();

            for (const key in this.form.data) {
                if (this.form.data[key] != null) {
                    data.append(key, this.form.data[key]);
                }
            }

            if (this.product) {

                data.append("_method", "PUT");

                axios.post('/product/' + this.product.id, data).catch(errors => {

                }).then(resp => {
                    this.$bvToast.toast('Sikeresen frissítve!', {
                        variant: 'success',
                        title: 'Siker'
                    })
                    this.form.busy = false;
                })

            } else {

                axios.post('/product', data)
                    .catch(errors => {
                        this.$bvToast.toast('Hiba történt!', {
                            variant: 'danger',
                            title: 'Hiba'
                        })
                        this.form.busy = false;
                    }).then(resp => {
                        if (!this.validationFailed) {
                            window.location = "/product";
                        }

                        this.form.busy = false;
                })
            }
        }

        back(){
            window.location = "/product";
        }

        resetForm() {

            let tags = [];

            if (this.product) {
                this.product.tags.forEach(function (tag) {
                    tags.push(tag.slug);
                })
            }

            this.form =  {
                data:{
                name_en: this.product ? this.product.name.en : "",
                name_hu: this.product ? this.product.name.hu : "",
                file: null,
                tags: this.product ? tags : null,
                publish_start: this.product ? moment(this.product.publish_start).format('YYYY-M-D') : "",
                publish_end: this.product ? moment(this.product.publish_end).format('YYYY-M-D') : "",
                description_en: this.product ? this.product.description.en : "",
                description_hu: this.product ? this.product.description.hu : "",
                price_en: this.product ? this.product.price.en : "",
                price_hu: this.product ? this.product.price.hu : ""
                },
                busy: false
            };
        }
    };
</script>
