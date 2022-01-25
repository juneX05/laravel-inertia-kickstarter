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
                / View Configuration
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
      <v-col cols="12" lg="7" md="7" sm="7">
        <v-card class="mt-2">
          <v-card-text>
            <v-btn small>Update Status</v-btn>
            <v-btn small>Update Price</v-btn>


            <inertia-link :href="route('editConfiguration',[this.configuration.id])" as="v-btn" small>
              Edit Configuration
            </inertia-link>
          </v-card-text>
          <v-card-title>
            {{ this.configuration.name }} Configuration
          </v-card-title>
          <v-card-text>
            {{ this.configuration.description }}
          </v-card-text>
          <v-card-text>
            <v-row>
              <v-col v-for="(configuration_amenity, index) in this.configuration.configuration_amenities" :key="index"
                     cols="3">
                <v-btn class="up_icon pa-10" width="100%">
                  <v-icon class="mb-3">{{ configuration_amenity.amenity.icon }}</v-icon>
                  <div>
                    {{ configuration_amenity.amenity.name }}
                  </div>
                </v-btn>
              </v-col>
            </v-row>


          </v-card-text>
        </v-card>
      </v-col>


      <v-col class="mb-3" cols="12" lg="5" md="5" sm="5">
        <h4 class="text-center">Current Configuration Images</h4>
        <v-row>
          <v-col v-for="(image, index) in old_configuration_images" :key="index" cols="6">
            <v-card>
              <v-img
                  :src=" '/uploads/' + image.name  "
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
