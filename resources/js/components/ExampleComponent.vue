<template>
  <div>
    <h1>EXAMPLE VUE COMPONENT</h1>
    <p>TEST</p>
  </div>
</template>

<script>
export default {
  name: "ExampleComponent",
  mounted() {
    console.log("ExampleComponent mounted");
  },
};
</script>

<style scoped>
h1 {
  color: rgb(68, 66, 185);
}
</style>
