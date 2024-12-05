<template>
    <button @click="openPostModal"
                    class="w-full max-w-[650px] rounded-2xl border border-gray-300 p-4 flex items-center bg-white shadow-md hover:shadow-lg transition-all mb-4 mx-auto"
                    style="max-height: 120px;">

                    <div class="relative flex-shrink-0">
                        <img src="/storage/images/default-contact.png" alt="contacto"
                            class="h-14 w-14 rounded-full border-4 border-blue-300 shadow-md" />
                    </div>

                    <span class="ml-4 text-black-600 text-lg font-medium">
                        ¿Qué estás pensando?
                    </span>
                </button>
    <div v-if="isModalOpen"
         class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50"
         @click.self="closePostModal">
      <div class="bg-white p-4 rounded-lg w-1/3 relative max-h-[80vh] overflow-y-auto" @click.stop>
  
        <!-- Botón de cerrar en la parte superior derecha -->
        <button @click="closePostModal" class="absolute top-2 right-5 text-2xl text-gray-600">
          &times;
        </button>
  
        <!-- Título del modal -->
        <h2 class="text-lg font-semibold text-center mb-4">Crear una publicación</h2>
  
        <!-- Área de texto para la publicación -->
        <textarea v-model="newPostText"
                  placeholder="¿Qué estás pensando, Caleth?"
                  class="w-full border border-neutral-300 rounded-lg p-4 mb-4 focus:outline-none resize-none"
                  style="min-height: 80px; overflow: auto;"></textarea>
  
        <!-- Vista previa de archivos cargados -->
        <div class="border border-neutral-300 rounded-lg p-4 mb-4"
             v-if="imagePreviews.length || videoPreviews.length || documentPreviews.length">
  
          <!-- Imágenes cargadas -->
          <div v-if="imagePreviews.length">
            <h3 class="text-sm font-semibold mb-2">Imágenes:</h3>
            <div class="flex gap-2">
              <img v-for="(img, index) in imagePreviews"
                   :key="index"
                   :src="img"
                   class="w-20 h-20 rounded-lg object-cover border border-gray-300" />
            </div>
          </div>
  
          <!-- Videos cargados -->
          <div v-if="videoPreviews.length" class="mt-4">
            <h3 class="text-sm font-semibold mb-2">Videos:</h3>
            <div class="flex gap-2">
              <video v-for="(video, index) in videoPreviews"
                     :key="index"
                     controls
                     class="w-20 h-20 rounded-lg border border-gray-300">
                <source :src="video" type="video/mp4" />
              </video>
            </div>
          </div>
  
          <!-- Documentos cargados -->
          <div v-if="documentPreviews.length" class="mt-4">
            <h3 class="text-sm font-semibold mb-2">Documentos:</h3>
            <ul class="list-disc list-inside text-sm">
              <li v-for="(doc, index) in documentPreviews" :key="index">{{ doc }}</li>
            </ul>
          </div>
        </div>
  
        <!-- Botones para subir archivos -->
        <div class="flex justify-between items-center gap-2 border border-neutral-300 p-4 rounded-lg mb-4">
          <!-- Botón para subir imágenes -->
          <label class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
            <FontAwesomeIcon icon="fa-solid fa-image" class="text-blue-500 text-2xl mb-1" />
            <span class="text-sm">Imágenes</span>
            <input type="file" accept="image/*" @change="uploadFiles('image', $event)" class="hidden" multiple />
          </label>
  
          <!-- Botón para subir videos -->
          <label class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
            <FontAwesomeIcon icon="fa-solid fa-video" class="text-green-500 text-2xl mb-1" />
            <span class="text-sm">Videos</span>
            <input type="file" accept="video/*" @change="uploadFiles('video', $event)" class="hidden" multiple />
          </label>
  
          <!-- Botón para subir documentos -->
          <label class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
            <FontAwesomeIcon icon="fa-solid fa-file-alt" class="text-purple-500 text-2xl mb-1" />
            <span class="text-sm">Documentos</span>
            <input type="file" accept=".pdf,.doc,.docx" @change="uploadFiles('document', $event)" class="hidden" multiple />
          </label>
        </div>
  
        <!-- Botón de publicar -->
        <div class="text-center">
          <button @click="submitPost"
                  class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-700 w-full">
            Publicar
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['isModalOpen', 'imagePreviews', 'videoPreviews', 'documentPreviews'],
    data() {
      return {
        newPostText: '',
      };
    },
    methods: {
      closePostModal() {
        this.$emit('closePostModal');
      },
      uploadFiles(type, event) {
        // Lógica para subir archivos
        console.log(type, event.target.files);
      },
      submitPost() {
        // Lógica para enviar la publicación
        console.log('Publicación:', this.newPostText);
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos adicionales, si es necesario */
  </style>
  