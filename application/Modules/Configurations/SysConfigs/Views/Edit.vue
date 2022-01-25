<template>
  <app-layout>
    <template #bread-crumbs>
      <inertia-link :href="route('home')" style="text-decoration: none">
        <v-icon size="16" style="margin-top: -2px">home</v-icon>
      </inertia-link>
      /
      <inertia-link :href="route('viewConfigurations')" style="text-decoration: none">
        Configurations List
      </inertia-link>
      <span class="text-md">
                / Edit Configuration
            </span>

      <br/>
      <inertia-link :href="route('viewConfigurations')" as="v-btn" class="mt-2" small style="text-decoration: none">
        <v-icon>arrow_back</v-icon>
        Back
      </inertia-link>
    </template>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Configurations
      </h2>
    </template>

    <v-row>
      <v-col cols="8">
        <v-card class="mt-2">
          <v-card-title>
            EDIT Configuration
          </v-card-title>
          <v-card-text class="pb-0">
            <v-form>
              <v-row>
                <v-col cols="12">
                  <configurationForm
                      :amenities="amenities"
                      :configuration_categories="configuration_categories"
                      :configuration_types="configuration_types"
                      :errors="errors"
                      :form="form"
                      :old_configuration_images="old_configuration_images"
                  ></configurationForm>
                </v-col>
              </v-row>


            </v-form>
          </v-card-text>
          <v-card-actions class="pt-0">
            <v-btn :loading="loading" dark @click="submit">Update Configuration</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>


      <v-col class="mb-3" cols="12" lg="4" md="4" sm="4">
        <h4 class="text-center">Current Configuration Images</h4>
        <v-row>
          <v-col v-for="(image, index) in old_configuration_images" :key="index" cols="6">
            <v-card>
              <v-img
                  :src=" '/storage/' + image.name  "
                  class="grey darken-4"
                  height="125"
              ></v-img>
              <v-card-actions class="text-h6">
                <v-btn v-if="image_id === null" color="red" icon @click="image_id = image.id">
                  <v-icon>
                    mdi-delete
                  </v-icon>
                </v-btn>
                <div v-if="image_id === image.id">
                  <p style="font-size: small">Are you sure you want to delete this image?</p>
                  <v-row no-gutters>
                    <v-btn :loading="image_removal_loading" dark small @click="removeConfigurationImage(image.id)">
                      YES
                    </v-btn>
                    <v-spacer/>
                    <v-btn small @click="image_id = null">
                      CANCEL
                    </v-btn>
                  </v-row>

                </div>
              </v-card-actions>
            </v-card>
          </v-col>

        </v-row>
      </v-col>
    </v-row>

  </app-layout>
</template>

<script>
import AppLayout from '@/Theme/Layouts/AppLayout'
import configurationForm from "@/Configurations/SysConfigs/Views/configurationForm";

export default {
  components: {
    configurationForm,
    AppLayout,
  },
  props: ['errors', 'configuration', 'configuration_categories', 'amenities', 'configuration_types'],
  mounted() {
    console.log(this.configuration)
  },
  data() {
    return {
      drawer: null,
      // form: this.permission,
      form: this.$inertia.form({
        id: this.configuration.id,
        name: this.configuration.name,
        number: this.configuration.number,
        configuration_category_id: this.configuration.configuration_category.id,
        configuration_type_id: this.configuration.configuration_type.id,
        description: this.configuration.description,
        configuration_amenities: this.configurationAmenities(),
        configuration_images: [],
      }),
      old_configuration_images: this.configuration.configuration_images,
      loading: false,
      image_id: null,
      image_removal_loading: false,
    }
  },
  computed: {},
  methods: {
    configurationAmenities() {
      let configuration_amenities = [];
      this.configuration.configuration_amenities.forEach((item) => {
        configuration_amenities.push(Number(item.amenity_id))
      })
      console.log(configuration_amenities);
      return configuration_amenities;
    },
    submit() {
      this.loading = true;
      this.form
          .transform(data => ({
            ...data,
          }))
          .post(this.route('updateConfiguration'), {
            onSuccess: () => {
              this.form.reset();
              this.$inertia.visit(route('viewConfigurations'))
            },
            onError: () => {
              console.log(this.errors)
            },
            onFinish: () => {
              this.loading = false;
            },
          })
    },
    removeConfigurationImage() {
      this.image_removal_loading = true;
      this.form
          .transform(data => ({
            id: this.image_id,
          }))
          .post(this.route('deleteConfigurationImage'), {
            onSuccess: () => {
              this.$inertia.visit(route('editConfiguration', [this.configuration.id]));
              // alert('Configuration Image Removed Successfully')
            },
            onError: () => {
              console.log(this.errors)
            },
            onFinish: () => {
              this.image_removal_loading = false;
            },
          })
    },
    checkErrors(key) {
      return this.errors[key] !== undefined;
    }
  }
}
</script>
