<template>
  <div class="page-container">
    <md-app md-waterfall md-mode="reveal">
      <md-app-toolbar class="md-primary">
        <md-button class="menu-open-button" @click="menuVisible = !menuVisible" v-if="!menuVisible">
          <md-icon>menu</md-icon>
        </md-button>
        <span class="md-title">{{ brandName }}</span>
      </md-app-toolbar>

      <md-app-drawer md-permanent="full" :md-active.sync="menuVisible" :md-swipeable="true">
        <md-toolbar class="md-transparent" md-elevation="0">
          Navigation
        </md-toolbar>

        <md-list>
          <md-list-item>
            <md-icon>home</md-icon>
            <span class="md-list-item-text">Home</span>
          </md-list-item>

          <md-list-item>
            <md-icon>info</md-icon>
            <span class="md-list-item-text">About</span>
          </md-list-item>
        </md-list>
      </md-app-drawer>

      <md-app-content>
        <product-selector></product-selector>
      </md-app-content>
    </md-app>
  </div>
</template>

<script>
    import ProductSelector from "./ProductSelector";

    export default {
        name: "Default",
        components: { ProductSelector },
        props: {
            brandName: ''
        },
        data: () => ({
            menuVisible: false
        })
    }
</script>

<style scoped>
  .md-drawer {
    width: 230px;
    max-width: calc(100vw - 125px);
  }
  @media (min-width: 600px) {
    .menu-open-button {
      display: none;
    }
  }
</style>