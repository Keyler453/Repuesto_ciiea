<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import HomeLayout from "@/Layouts/HomeLayout.vue";
import axios from "axios";
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faComment, faHeart, faImage, faVideo, faFileAlt, faBell, faUser, faHouse, faEllipsis } from "@fortawesome/free-solid-svg-icons";
import { library } from '@fortawesome/fontawesome-svg-core';
// import SearchBar from './pages/Form/SearchBar.vue';


// Añadir iconos de FontAwesome a la biblioteca
library.add(faImage, faVideo, faFileAlt, faBell, faUser, faHouse, faEllipsis);


const imagePreviews = ref([]); // Para múltiples imágenes
const videoPreviews = ref([]); // Para múltiples videos
const documentPreviews = ref([]); // Para múltiples documentos
const notifications = ref([]);


// Método para manejar la carga de archivos
const uploadFiles = (type, event) => {
    const files = event.target.files;

    if (files) {
        Array.from(files).forEach((file) => {
            const reader = new FileReader();

            if (type === "image") {
                reader.onload = () => {
                    imagePreviews.value.push(reader.result);
                };
                reader.readAsDataURL(file);
            } else if (type === "video") {
                videoPreviews.value.push(URL.createObjectURL(file));
            } else if (type === "document") {
                documentPreviews.value.push(file.name);
            }
        });
    }
};

// Estado para manejar las publicaciones
const newPostText = ref('');
const posts = ref([]);

// Funciones del modal para publicaciones
const isModalOpen = ref(false);

const openPostModal = () => {
    isModalOpen.value = true;
    document.body.style.overflow = 'hidden';
};

const closePostModal = () => {
    isModalOpen.value = false;
    document.body.style.overflow = '';
};

const submitPost = async () => {
    if (newPostText.value.trim() !== '') {
        try {
            // Obtener los datos de los comentarios y likes actuales
            const currentComments = posts.value.reduce((comments, post) => {
                if (post.comments) {
                    comments = [...comments, ...post.comments];
                }
                return comments;
            }, []);

            // Enviar la publicación al backend, incluyendo los comentarios y likes
            const response = await axios.post('/posts', {
                text: newPostText.value,
                images: imagePreviews.value,
                videos: videoPreviews.value,
                documents: documentPreviews.value,
                comments: currentComments, // Incluir los comentarios actuales
                likes: 0, // Inicializar los likes en 0
            });

            // Agregar la nueva publicación a la lista local
            posts.value.unshift({
                ...response.data,
                comments: [],
                liked: false,
                showCommentInput: false,
                newComment: '',
            });

            localStorage.setItem('posts', JSON.stringify(posts.value));

            // Limpiar los campos después de la publicación
            newPostText.value = '';
            imagePreviews.value = [];
            videoPreviews.value = [];
            documentPreviews.value = [];

            // Cerrar el modal
            closePostModal();
        } catch (error) {
            console.error('Error al guardar la publicación:', error);
        }
    } else {
        console.log('El contenido de la publicación está vacío.');
    }
};

// Función para mostrar u ocultar el campo de comentario
function toggleCommentInput(postId) {
    const post = posts.value.find((p) => p.id === postId);
    post.showCommentInput = !post.showCommentInput;
}

// Función para enviar un comentario
function submitComment(postId) {
    const post = posts.value.find((p) => p.id === postId);
    if (post.newComment.trim() !== '') {
        post.comments.push({
            text: post.newComment,
            timestamp: new Date(),
        });
        post.newComment = ''; // Limpiar el campo de comentario
        post.showCommentInput = false;
    }
}

// Función para manejar el like de la publicación
function toggleLike(postId) {
    const post = posts.value.find((p) => p.id === postId);
    post.liked = !post.liked;
    post.likes += post.liked ? 1 : -1;
}


const openMenuId = ref(null);

// Función para alternar el menú
function toggleMenu(postId) {
    openMenuId.value = openMenuId.value === postId ? null : postId;
}

// Función para cerrar el menú al hacer clic fuera de él
function handleClickOutside(event) {
    const menu = document.querySelector('.menu-container');
    if (!menu || !menu.contains(event.target)) {
        openMenuId.value = null;
    }
}

// Funciones para las acciones del menú
function editPost(postId) {
    console.log('Editando post:', postId);
}

function deletePost(postId) {
    posts.value = posts.value.filter(post => post.id !== postId);
    localStorage.setItem('posts', JSON.stringify(posts.value)); // Actualizar el localStorage
    console.log('Post eliminado:', postId);
}

function reportPost(postId) {
    console.log('Reportando post:', postId);
}

// Configuración para cerrar el menú al hacer clic fuera de él
onMounted(() => {
    document.addEventListener('click', handleClickOutside);
    const savedPosts = localStorage.getItem('posts');
    if (savedPosts) {
        posts.value = JSON.parse(savedPosts);
    }
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
// Datos de los investigadores
const investigadores = {
    ciro: { nombre: "Ciro Gómez Leyva", descripcion: "Descripción de Ciro Gómez Leyva." },
    ernesto: { nombre: "Ernesto Guzmán Sánchez", descripcion: "Descripción de Ernesto Guzmán Sánchez." },
    jaime: { nombre: "Jaime López Méndez", descripcion: "Descripción de Jaime López Méndez." },
};

// Modal de investigadores
const showModal = ref(false);
const modalData = ref({ nombre: "", descripcion: "" });

function openModal(investigador) {
    modalData.value = investigadores[investigador];
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
}

// Redirigir al formulario
function redirectToForm() {
    window.location.href = "/form/record-reime";
}

function getDocumentUrl(doc) {
    return `/documents/${doc}`;
}

// Definir la estructura del layout
defineOptions({
    layout: HomeLayout,
});

// Props
const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>


<template>

    <Head title="REIME" />

    <div class="relative flex w-full justify-between gap-4 px-4 pb-10 pt-20 sm:p-8">


        <section class="sticky top-20 hidden h-full w-1/4 sm:flex sm:flex-col">
            <div class="flex flex-col rounded-lg bg-white px-4 pb-4 pt-2">
                <h1 class="font-medium text-neutral-500">Menú</h1>
                <div class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <font-awesome-icon :icon="['fas', 'house']" class="mr-4 text-[#00416A] text-2xl" />
                    <span class="font-bold">Inicio</span>
                </div>
                <div class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <font-awesome-icon :icon="['fas', 'bell']" class="mr-4 text-[#00416A] text-2xl" />
                    <span class="font-bold">Notificaciones</span>
                </div>
                <div class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <font-awesome-icon :icon="['fas', 'user']" class="mr-4 text-[#00416A] text-2xl" />
                    <span class="font-bold">Perfil</span>
                </div>

                <button @click="redirectToForm"
                    class="mt-6 rounded-lg px-4 py-2 text-white hover:bg-blue-700 bounce-animation"
                    style="background-color: #00416A; color: white;">
                    ¿Quieres formar parte de la REIME?
                </button>

            </div>

            <div class="flex flex-col rounded-lg bg-white px-4 pb-4 pt-2 mt-4">
                <h1 class="font-medium text-neutral-500">Investigadores</h1>
                <div @click="openModal('ciro')"
                    class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <img src="/storage/images/default-contact.png" alt="contacto" class="mr-4 h-12 w-12" />
                    <div class="flex items-center">
                        <h3 class="font-bold">Ciro Gómez Leyva</h3>
                    </div>
                </div>
                <div @click="openModal('ernesto')"
                    class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <img src="/storage/images/default-contact.png" alt="contacto" class="mr-4 h-12 w-12" />
                    <div class="flex items-center">
                        <h3 class="font-bold">Ernesto Guzmán Sánchez</h3>
                    </div>
                </div>
                <div @click="openModal('jaime')"
                    class="mt-4 flex w-full cursor-pointer justify-start rounded-lg px-4 py-2 hover:bg-neutral-200">
                    <img src="/storage/images/default-contact.png" alt="contacto" class="mr-4 h-12 w-12" />
                    <div class="flex items-center">
                        <h3 class="font-bold">Jaime López Méndez</h3>
                    </div>
                </div>
                <button @click="" class="mt-6 rounded-lg px-4 py-2 text-white bg-[#00416A]">
                    Mostrar más
                </button>
            </div>
        </section>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-8 rounded-lg max-w-sm w-full">
                <span class="cursor-pointer float-right" @click="closeModal">✖</span>
                <h2 class="text-xl font-bold mb-4">{{ modalData.nombre }}</h2>
                <p>{{ modalData.descripcion }}</p>
            </div>
        </div>


        <section class="flex w-1/2 flex-col gap-y-6 ">
            <div>
                <div>
                </div>
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

                        <!-- Botón de cerrar en la parte superior izquierda -->
                        <button @click="closePostModal" class="absolute top-2 right-5 text-2xl text-gray-600">
                            &times;
                        </button>

                        <!-- Título centrado -->
                        <h2 class="text-lg font-semibold text-center mb-4">Crear una publicación</h2>

                        <!-- Área de texto de la publicación, más grande -->

                        <textarea v-model="newPostText" placeholder="¿Qué estás pensando, Caleth?"
                            class="w-full border border-neutral-300 rounded-lg p-4 mb-4 focus:outline-none resize-none"
                            style="min-height: 80px; overflow: auto;"></textarea>

                        <!-- Vista previa de archivos cargados -->
                        <div class="border border-neutral-300 rounded-lg p-4 mb-4"
                            v-if="imagePreviews.length || videoPreviews.length || documentPreviews.length">
                            <!-- Vista previa de imágenes -->
                            <div v-if="imagePreviews.length">
                                <h3 class="text-sm font-semibold mb-2">Imágenes:</h3>
                                <div class="flex gap-2">
                                    <img v-for="(img, index) in imagePreviews" :key="index" :src="img"
                                        class="w-20 h-20 rounded-lg object-cover border border-gray-300" />
                                </div>
                            </div>

                            <!-- Vista previa de videos -->
                            <div v-if="videoPreviews.length" class="mt-4">
                                <h3 class="text-sm font-semibold mb-2">Videos:</h3>
                                <div class="flex gap-2">
                                    <video v-for="(video, index) in videoPreviews" :key="index" controls
                                        class="w-20 h-20 rounded-lg border border-gray-300">
                                        <source :src="video" type="video/mp4" />
                                    </video>
                                </div>
                            </div>

                            <!-- Vista previa de documentos -->
                            <div v-if="documentPreviews.length" class="mt-4">
                                <h3 class="text-sm font-semibold mb-2">Documentos:</h3>
                                <ul class="list-disc list-inside text-sm">
                                    <li v-for="(doc, index) in documentPreviews" :key="index">{{ doc }}</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Contenedor de botones para subir archivos -->
                        <div
                            class="flex justify-between items-center gap-2 border border-neutral-300 p-4 rounded-lg mb-4">
                            <!-- Botón para subir imágenes -->
                            <label
                                class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
                                <FontAwesomeIcon icon="fa-solid fa-image" class="text-blue-500 text-2xl mb-1" />
                                <span class="text-sm">Imágenes</span>
                                <input type="file" accept="image/*" @change="uploadFiles('image', $event)"
                                    class="hidden" multiple />
                            </label>

                            <!-- Botón para subir videos -->
                            <label
                                class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
                                <FontAwesomeIcon icon="fa-solid fa-video" class="text-green-500 text-2xl mb-1" />
                                <span class="text-sm">Videos</span>
                                <input type="file" accept="video/*" @change="uploadFiles('video', $event)"
                                    class="hidden" multiple />
                            </label>

                            <!-- Botón para subir documentos -->
                            <label
                                class="cursor-pointer flex flex-col items-center justify-center text-center p-2 bg-gray-100 rounded-lg w-1/3 hover:bg-gray-200">
                                <FontAwesomeIcon icon="fa-solid fa-file-alt" class="text-purple-500 text-2xl mb-1" />
                                <span class="text-sm">Documentos</span>
                                <input type="file" accept=".pdf,.doc,.docx" @change="uploadFiles('document', $event)"
                                    class="hidden" multiple />
                            </label>
                        </div>

                        <div class="text-center">
                            <button @click="submitPost"
                                class="bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-700 w-full">Publicar</button>
                        </div>
                    </div>
                </div>


                <!-- Lista de publicaciones -->

                <div v-for="(post, index) in posts" :key="post.id"
                    class="rounded-lg bg-white ring-1 ring-neutral-200 hover:ring-2 hover:ring-sky-900 mb-2 shadow-sm p-2 max-w-[650px] mx-auto">

                    <div class="px-4 py-2 text-neutral-800">
                        <div class="flex items-center justify-between mb-2 relative">
                            <div class="flex items-center">
                                <h3 class="mr-2 text-neutral-600 hover:underline">Publicado por {{ post.author }}</h3>
                                <h3 class="text-neutral-600">{{ new Date(post.timestamp).toLocaleString() }}</h3>
                            </div>
                            <!-- Botón con el menú -->
                            <button @click.stop="toggleMenu(post.id)"
                                class="text-gray-600 hover:text-gray-900 focus:outline-none text-2xl relative">
                                <FontAwesomeIcon :icon="['fas', 'ellipsis-h']" />
                            </button>

                            <!-- Menú desplegable -->
                            <ul v-if="openMenuId === post.id"
                                class="absolute right-0 mt-2 w-40 bg-white border border-neutral-200 rounded-lg shadow-lg z-50 text-sm ring-1 ring-neutral-200 transition-all duration-150">
                                <li @click="editPost(post.id)"
                                    class="py-2 px-4 hover:bg-[#00416A] hover:text-white rounded-lg cursor-pointer transition-colors duration-150">
                                    Editar
                                </li>
                                <li @click="deletePost(post.id)"
                                    class="py-2 px-4 hover:bg-[#00416A] hover:text-white rounded-lg cursor-pointer transition-colors duration-150">
                                    Eliminar
                                </li>
                                <li @click="reportPost(post.id)"
                                    class="py-2 px-4 hover:bg-[#00416A] hover:text-white rounded-lg cursor-pointer transition-colors duration-150">
                                    Reportar
                                </li>
                            </ul>
                        </div>
                        <p class="mb-2">
                            {{ post.text }}
                        </p>
                    </div>


                    <!-- Imágenes -->
                    <div v-if="post.images.length" class="px-4 py-2">
                        <div class="flex justify-center items-center">
                            <!-- Si hay solo una imagen -->
                            <div v-if="post.images.length === 1" class="w-full max-w-[600px] mx-auto">
                                <img :src="post.images[0]" class="w-full h-auto rounded-lg object-cover" />
                            </div>

                            <!-- Si hay dos o más imágenes -->
                            <div v-else class="grid grid-cols-2 gap-2 max-w-[600px] mx-auto">
                                <img v-for="(img, idx) in post.images.slice(0, 4)" :key="idx" :src="img"
                                    class="w-full h-auto rounded-lg object-cover" />

                                <!-- Botón "Ver más" si hay más de 4 imágenes -->
                                <div v-if="post.images.length > 4" class="col-span-2 text-center mt-2">
                                    <button @click="viewMoreImages(post.id)" class="text-blue-600">Ver más</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Videos -->
                    <div v-if="post.videos.length" class="px-4 py-2">
                        <h3 class="text-sm font-bold mb-2 text-neutral-800">Videos:</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <video v-for="(video, idx) in post.videos" :key="idx" controls
                                class="w-full rounded-lg object-cover">
                                <source :src="video" type="video/mp4" />
                            </video>
                        </div>
                    </div>

                    <!-- Documentos -->
                    <div v-if="post.documents.length" class="px-4 py-2">
    <h3 class="text-sm font-bold mb-2 text-neutral-800">Documentos:</h3>
    <ul class="list-disc pl-5">
      <li v-for="(doc, idx) in post.documents" :key="idx"
          class="text-neutral-600 hover:underline cursor-pointer">
        <font-awesome-icon :icon="['fas', 'file-alt']" class="mr-2 text-neutral-600" />
        <a :href="getDocumentUrl(doc)" target="_blank" class="text-blue-500">{{ doc }}</a>
      </li>
    </ul>
  </div>

                    <!-- Interacciones -->
                    <div class="flex flex-col w-full border-t border-neutral-200">
                        <!-- Reacciones y estadísticas -->
                        <div class="flex items-center justify-between px-4 py-2 text-sm text-neutral-600">
                            <div class="flex items-center gap-2">
                                <FontAwesomeIcon icon="fa-heart" class="text-red-500" />
                                <span>{{ post.likes }} Me gusta</span>
                            </div>
                            <div class="flex gap-4">
                                <span>{{ post.comments.length }} comentarios</span>
                            </div>
                        </div>

                        <!-- Botones de interacción -->
                        <div class="flex justify-around py-2 border-t border-neutral-200 text-neutral-800 text-sm">
                            <button @click="toggleLike(post.id)" class="hover:text-rose-500">
                                <FontAwesomeIcon :icon="faHeart" :class="{ 'text-rose-500': post.liked }" />
                                Me gusta
                            </button>
                            <button @click="toggleCommentInput(post.id)"
                                class="flex items-center gap-1 hover:text-green-500">
                                <FontAwesomeIcon :icon="faComment" />
                                Comentar
                            </button>
                        </div>
                    </div>

                    <!-- Comentarios -->
                    <div v-if="post.showCommentInput" class="bg-gray-100 rounded-lg p-4">
                        <textarea v-model="post.newComment" placeholder="Escribe tu comentario aquí..."
                            class="w-full rounded-lg border border-neutral-300 p-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                            style="max-height: 100px;"></textarea>
                        <div class="flex justify-end mt-3">
                            <button @click="submitComment(post.id)"
                                class="rounded-lg px-4 py-2 font-semibold text-sm bg-blue-600 text-white hover:bg-blue-700 transition duration-200">
                                Enviar comentario
                            </button>
                        </div>
                    </div>

                    <!-- Lista de comentarios -->
                    <div class="mt-4 bg-white rounded-lg shadow-sm p-4">
                        <h3 class="text-md font-semibold mb-3 text-gray-700">Comentarios:</h3>
                        <ul class="space-y-3">
                            <li v-for="(comment, index) in post.comments" :key="index"
                                class="bg-gray-50 rounded-lg p-3 shadow-sm">
                                <p class="text-gray-800 text-sm">{{ comment.text }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ new Date(comment.timestamp).toLocaleString() }}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <section class="sticky top-20 hidden h-full w-1/4 sm:flex sm:flex-col">

            <div class="relative">
                <!-- Icono de lupa -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <!-- Campo de búsqueda -->
                <input type="search" id="search-input"
                    class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-blue-500 focus:border-blue-500 focus:shadow-xl focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:focus:shadow-xl transition duration-300 ease-in-out"
                    placeholder="Buscar..." required />

                <!-- Botón de búsqueda -->
                <button type="submit"
                    class="absolute right-2.5 bottom-2.5 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 text-white font-medium rounded-lg text-sm px-4 py-2 transition duration-300 ease-in-out hover:scale-105"
                    style="background-color:  #00416A;">
                    Buscar
                </button>
            </div>
            <div class="mb-6 flex flex-col rounded-lg bg-white px-4 pb-4 pt-2 mt-4">
                <h1 class="font-medium text-neutral-500">
                    Publicaciones
                </h1>
                <div class="mt-4 w-full cursor-pointer rounded-lg bg-neutral-200 px-4 py-2">
                    <div class="mb-2 flex justify-between">
                        <h3 class="font-bold">Publicación 1</h3>
                        <h3>
                            <FontAwesomeIcon :icon="faComment" />
                            15
                        </h3>
                        <h3>
                            <FontAwesomeIcon :icon="faHeart" />
                            30
                        </h3>
                    </div>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Sint natus tempora asperiores fugit facilis amet
                        recusandae quia...
                    </p>
                </div>
                <div class="mt-4 w-full cursor-pointer rounded-lg bg-neutral-200 px-4 py-2">
                    <div class="mb-2 flex justify-between">
                        <h3 class="font-bold">Publicación 2</h3>
                        <h3>
                            <FontAwesomeIcon :icon="faComment" />
                            15
                        </h3>
                        <h3>
                            <FontAwesomeIcon :icon="faHeart" />
                            30
                        </h3>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Veritatis temporibus nesciunt eos ea...
                    </p>
                </div>
                <div class="mt-4 w-full cursor-pointer rounded-lg bg-neutral-200 px-4 py-2">
                    <div class="mb-2 flex justify-between">
                        <h3 class="font-bold">Publicación 3</h3>
                        <h3>
                            <FontAwesomeIcon :icon="faComment" />
                            15
                        </h3>
                        <h3>
                            <FontAwesomeIcon :icon="faHeart" />
                            30
                        </h3>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit. Laborum debitis tempora veritatis minima...
                    </p>
                </div>
            </div>
        </section>
    </div>
</template>
<style>
/* Estilo para la animación de rebote */
@keyframes bounce {

    0%,
    20%,
    50%,
    80%,
    100% {
        transform: translateY(0);
    }

    40% {
        transform: translateY(-10px);
    }

    60% {
        transform: translateY(-5px);
    }
}

.bounce-animation {
    animation: bounce 3s infinite;
}
</style>
