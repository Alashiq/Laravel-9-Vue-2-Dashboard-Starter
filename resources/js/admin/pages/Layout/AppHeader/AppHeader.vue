<template>
    <div
        class="h-20 w-full bg-white mb-8 flex justify-between items-center px-3 layout-shadow"
    >


    <div class="flex flex-wrap items-center font-normal cairo text-sm text-gray-500 hover-side-menu cursor-pointer px-2 py-1 rounded-lg">
        <div class="border rounded-full flex items-center justify-center">
            <img :src="user.photo" class="w-10 h-10 m-1 rounded-full " alt="">
          </div>
          <div class="mr-2">
            مرحبا بك

          </div>
          <div class="mr-1 font-medium">
            {{ user.first_name }}
          </div>
          <div class="mr-2">
            <i class="fa-solid fa-chevron-down"></i>
          </div>
    </div>

        <div @click="toggleMenu" class="h-16 w-16 text-gray-600 flex items-center justify-center text-3xl hover:text-red-400 cursor-pointer md:hidden">
            <i class="fas fa-bars"></i>
        </div>


    </div>
</template>

<script>
export default {
    data: function() {
        return {};
    },
    methods: {
        toggleMenu(){
                    this.$store.commit("toggleMenu");
        }
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
    }
};
</script>

<style></style>
