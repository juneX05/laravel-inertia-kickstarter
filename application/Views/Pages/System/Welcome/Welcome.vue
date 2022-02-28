<template>
  <website-layout>

    <home-hero />
    <home-details />
  </website-layout>

</template>

<script>
import WebsiteLayout from "@/Theme/Layouts/WebsiteLayout";
import HomeHero from "@/Pages/System/Welcome/components/HomeHero";
import HomeDetails from "@/Pages/System/Welcome/components/HomeDetails";
export default {
  name: 'Welcome',
  components: {HomeDetails, HomeHero, WebsiteLayout},
  data() {
    return {

    }
  }
};
</script>

