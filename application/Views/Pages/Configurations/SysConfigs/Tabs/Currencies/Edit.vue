<template>
    <sys-config-index>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            New Currency
          </h3>
          <div class="card-tools">

          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="name"> Name</label>
            <input type="text" id="name" v-model="form.name" class="form-control">
          </div>
          <div class="form-group">
            <label for="abbreviation"> Abbreviation</label>
            <input type="text" id="abbreviation" v-model="form.abbreviation" class="form-control">
          </div>
          <div class="form-group">
            <label for="symbol"> Symbol</label>
            <input type="text" id="symbol" v-model="form.symbol" class="form-control">
          </div>
        </div>

        <div class="card-footer">
          <button class="btn btn-primary" @click="submit">
            Update Currency
          </button>
        </div>

      </div>
    </sys-config-index>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import CurrencyForm from "@/Pages/Configurations/SysConfigs/Tabs/Currencies/currencyForm";
import SysConfigIndex from "../../SysConfigIndex";

export default {
    components: {
      SysConfigIndex,
      CurrencyForm,
        AppLayout,
    },
    props: ['errors','currency'],
    mounted() {
        console.log(this.currency)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                id:this.currency.id,
                name:this.currency.name,
                abbreviation:this.currency.abbreviation,
                symbol:this.currency.symbol,
            }),
            loading:false
        }
    },

    methods: {
        submit() {
            this.loading = true;
            this.form
                .transform(data => ({
                    ... data,
                }))
                .post(this.route('updateCurrency'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewCurrencies'))
                    },
                    onError: () => {
                        console.log(this.errors)
                    },
                    onFinish: () => {
                        this.loading = false;
                    },
                })
        },
        checkErrors(key) {
            return this.errors[key] !== undefined;
        }
    }
}
</script>
