<template>
  <v-container fluid fill-height class="home-hero" style="max-height: 100vh">
    <v-row justify="center" align="center" align-content="center" pa-5>
      <v-col cols="12" class="text-center" lg="7" sm="8">
        <div :class="getDisplayFontSize()" class=" font-weight-black white--text text-center">
          TITLE PART ONE
        </div>
        <div :class="getDisplayFontSize()"
             class="font-weight-black white--text text-center mb-3">
           PART TWO
        </div>
        <div :class="getDisplayFontSize()"
             class="font-weight-black white--text text-center mb-3">
          PART THREE
        </div>
        <div class="display-1 font-weight-bold white--text text-center">
          Some good words about the title and description with beautiful meaning
        </div>
        <v-btn fab class="mt-5 brown darken-4" href="#categories">
          <v-icon large color="white">expand_more</v-icon>
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "HomeHero",
  methods: {
    getDisplayFontSize() {
      if (this.$vuetify.breakpoint.smAndDown) {
        return 'display-2'
      } else if (this.$vuetify.breakpoint.mdAndDown) {
        return 'display-3'
      } else {
        return 'display-4'
      }
    }
  }
}
</script>


<style>
.home-hero {
  background: url('http://source.unsplash.com/0BhSKStVtdM');
  background-size: cover;
  width: 100%;
  height: 100%;
}
</style>