<template>
    <dev-configs-index>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            New Status
          </h3>
          <div class="card-tools">

          </div>
        </div>
        <div class="card-body">
          <status-form
              :errors="errors"
              :form="form"
          ></status-form>
        </div>

        <div class="card-footer">
          <button class="btn btn-primary" @click="submit">
            Save Status
          </button>
        </div>

      </div>


    </dev-configs-index>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import StatusForm from "@/Pages/Configurations/DevConfigs/Tabs/Statuses/statusForm";
import DevConfigsIndex from "../../DevConfigsIndex";

export default {
    components: {
      DevConfigsIndex,
      StatusForm,
        AppLayout,
    },
    props: ['errors'],
    data() {
        return {
            drawer: null,
            form: this.$inertia.form({
                name: '',
                id: '',
                color: '',
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
                .post(this.route('saveStatus'), {
                    onSuccess: () => {
                        this.form.reset();
                        this.$inertia.visit(route('viewStatuses'))
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
