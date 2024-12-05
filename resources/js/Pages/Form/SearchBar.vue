<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faBell, faUser, faCog } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';

// Añadir iconos de FontAwesome a la biblioteca
library.add(faBell, faUser, faCog);

// Estado para las notificaciones (puedes ajustar esto según cómo obtienes las notificaciones)
const notifications = ref([]);
</script>

<style scoped>
/* Estilos personalizados para el navbar si es necesario */
</style>
<template>
  <!-- Navbar -->
  <nav class="flex items-center justify-between p-4 bg-white shadow-md">
    <!-- Barra de Búsqueda -->
    <form class="max-w mx-auto mb-4 flex-1">
      <label for="search-input" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
      <div class="relative">
        <!-- Icono de lupa -->
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>

        <!-- Campo de búsqueda -->
        <input type="search" id="search-input"
          class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 focus:shadow-xl focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:focus:shadow-xl transition duration-300 ease-in-out"
          placeholder="¿Qué búsqueda haremos el día de hoy?" required />

        <!-- Botón de búsqueda -->
        <button type="submit"
          class="absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-4 py-2 transition duration-300 ease-in-out hover:scale-105 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
          Buscar
        </button>
      </div>
    </form>

    <!-- Iconos -->
    <div class="flex items-center space-x-4">
      <!-- Icono de Notificación -->
      <div class="relative cursor-pointer">
        <FontAwesomeIcon icon="fa-bell" class="text-blue-500 text-3xl" />
        <!-- Si tienes notificaciones no leídas, puedes agregar un contador -->
        <span v-if="notifications.length" class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
          {{ notifications.length }}
        </span>
      </div>

      <!-- Otros iconos -->
      <div class="cursor-pointer">
        <FontAwesomeIcon icon="fa-user" class="text-blue-500 text-3xl" />
      </div>
      <div class="cursor-pointer">
        <FontAwesomeIcon icon="fa-cog" class="text-blue-500 text-3xl" />
      </div>
    </div>
  </nav>
</template>

