<template>
    <sys-config-index>

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">
            Edit Status
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
            Update Status
          </button>
        </div>

      </div>
    </sys-config-index>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import StatusForm from "@/Pages/Configurations/DevConfigs/Tabs/Statuses/statusForm";
import SysConfigIndex from "../../../SysConfigs/SysConfigIndex";

export default {
    components: {
      SysConfigIndex,
      StatusForm,
        AppLayout,
    },
    props: ['errors','status'],
    mounted() {
        console.log(this.status)
    },
    data() {
        return {
            drawer: null,
            // form: this.permission,
            form: this.$inertia.form({
                key_id:this.status.id,
                id:this.status.id,
                name:this.status.name,
                color:this.status.color,
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
                .post(this.route('updateStatus'), {
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
