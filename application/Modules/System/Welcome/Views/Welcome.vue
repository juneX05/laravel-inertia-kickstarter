<template>
  <website-layout>

    <home-hero />
    <home-details />
  </website-layout>

</template>

<script>
import WebsiteLayout from "@/Theme/Layouts/WebsiteLayout";
import HomeHero from "@/System/Welcome/Views/components/HomeHero";
import HomeDetails from "@/System/Welcome/Views/components/HomeDetails";
export default {
  name: 'Welcome',
  components: {HomeDetails, HomeHero, WebsiteLayout},
  data() {
    return {

    }
  }
};
</script>

