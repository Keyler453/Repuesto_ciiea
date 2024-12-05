<!-- resources/js/Components/SubmissionMessage.vue
<template>
    <div v-if="isVisible" class="fixed top-0 left-0 right-0 bottom-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full text-center">
        <h3 class="text-xl font-semibold mb-4">¡Solicitud Enviada!</h3>
        <p class="text-gray-600">Tu solicitud está en revisión. Se te notificará al correo una vez procesada.</p>
        <button @click="closeMessage" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
          Cerrar
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // Usamos un ref para manejar la visibilidad del mensaje
  const isVisible = ref(true);
  
  // Función para cerrar el mensaje
  const closeMessage = () => {
    isVisible.value = false;
  };
  </script>
  
  <style scoped>
  /* Puedes añadir estilos adicionales aquí */
  </style>
  
   -->