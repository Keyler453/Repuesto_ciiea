<template>
    <div class="container">
      <h1 class="text-2xl font-semibold mb-4">Investigadores Destacados</h1>
  
      <div v-if="loading" class="text-center">Cargando registros...</div>
      <div v-else>
        <table class="min-w-full bg-white border border-gray-300">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">Nombre Completo</th>
              <th class="py-2 px-4 border-b">Email</th>
              <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="investigador in investigadores" :key="investigador.id">
              <td class="py-2 px-4 border-b">{{ investigador.nombreCompleto }}</td>
              <td class="py-2 px-4 border-b">{{ investigador.emailInstitucional }}</td>
              <td class="py-2 px-4 border-b">
                <button 
                  @click="openModal(investigador)" 
                  class="text-blue-500 hover:text-blue-700">Ver detalles</button>
              </td>
            </tr>
          </tbody>
        </table>
  
        <button 
          @click="redirectToForm"
          class="mt-6 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
          ¿Quieres formar parte de la REIME?
        </button>
      </div>
  
      <!-- Modal (Opcional) -->
      <modal v-if="showModal" :investigador="modalData" @close="closeModal"></modal>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { ref, onMounted } from 'vue';
  
  export default {
    name: 'RecordsIndex',
    components: {
      Modal,
    },
    setup() {
      const investigadores = ref([]);
      const loading = ref(true);
      const showModal = ref(false);
      const modalData = ref(null);
  
      // Función para obtener los registros de la base de datos
      const fetchInvestigadores = async () => {
        try {
          const response = await axios.get('/api/records'); // Suponiendo que esta es tu ruta API
          investigadores.value = response.data;
        } catch (error) {
          console.error("Error al obtener los investigadores:", error);
        } finally {
          loading.value = false;
        }
      };
  
      // Abrir el modal con los detalles de un investigador
      const openModal = (investigador) => {
        modalData.value = investigador;
        showModal.value = true;
      };
  
      // Cerrar el modal
      const closeModal = () => {
        showModal.value = false;
        modalData.value = null;
      };
  
      // Redirigir al formulario para agregar un nuevo registro
      const redirectToForm = () => {
        window.location.href = '/form/record-reime'; // Ruta a tu formulario
      };
  
      // Cargar los investigadores al montar el componente
      onMounted(fetchInvestigadores);
  
      return {
        investigadores,
        loading,
        showModal,
        modalData,
        openModal,
        closeModal,
        redirectToForm,
      };
    },
  };
  </script>
  
  <style scoped>
  .container {
    padding: 20px;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    text-align: left;
    padding: 12px;
    border: 1px solid #ddd;
  }
  
  th {
    background-color: #f4f4f4;
  }
  </style>
  