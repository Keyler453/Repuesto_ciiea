<script setup>
import { ref } from 'vue'
import GuestLayout from "@/Layouts/FormLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    nombreCompleto: "",
    edad: "",
    sexo: "",
    gradoEstudios: "",
    institucion: "",
    departamento: "",
    direccionInstitucion: "",
    ciudad: "",
    estado: "",
    tipoInstitucion: "",
    telefonoOficina: "",
    celular: "",
    emailInstitucional: "",
    emailPersonal: "",
    lineaInvestigacion: "",
    nivelEducativo: "",
    usuario: "",
    correo: "",
    contrasena: "",
});


const isVisible = ref(false);

// Función para cerrar el mensaje
const closeMessage = () => {
    isVisible.value = false;
};

const submit = () => {
    form.post(route("records.store"), { // Cambiar a "records.store"
        onSuccess: () => {
            console.log("Formulario enviado con éxito");
            form.reset();
            isVisible.value = true;
        },
        onError: (errors) => {
            console.error("Errores al enviar el formulario:", errors);
            // Aquí puedes manejar errores específicos si lo deseas
        },
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Ficha de Registro" />
        <form @submit.prevent="submit"> <!-- Usar solo un formulario -->
            <div class="max-w-5xl mx-auto p-8 bg-white rounded-lg shadow-md ring-1 ring-gray-200">
                <h2 style="text-align: center; margin-bottom: 20px;" class="text-2xl font-bold">
                    RED ESTATAL DE INVESTIGADORES EN MATERIA EDUCATIVA
                </h2>
                <h3 style="text-align: center;" class="text-2xl font-bold">Ficha de Registro</h3>

                <!-- Información Personal -->
                <section class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Información Personal</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                            <input v-model="form.nombreCompleto" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Nombre completo">
                            <InputError :message="form.errors.nombreCompleto" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Edad</label>
                            <input v-model="form.edad" type="number" min="0"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Edad">
                            <InputError :message="form.errors.edad" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sexo</label>
                            <select v-model="form.sexo" class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                                <option value="">Selecciona una opción</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="otro">Otro</option>
                            </select>
                            <InputError :message="form.errors.sexo" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Grado Máximo de Estudios</label>
                            <input v-model="form.gradoEstudios" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Ej. Doctorado">
                            <InputError :message="form.errors.gradoEstudios" />
                        </div>
                    </div>
                </section>

                <!-- Información Institucional -->
                <section class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Información Institucional</h4>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Institución donde labora</label>
                        <input v-model="form.institucion" type="text"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                            placeholder="Nombre de la institución">
                        <InputError :message="form.errors.institucion" />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Departamento o Área de
                                Adscripción</label>
                            <input v-model="form.departamento" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Departamento o área">
                            <InputError :message="form.errors.departamento" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dirección de la Institución</label>
                            <input v-model="form.direccionInstitucion" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Dirección">
                            <InputError :message="form.errors.direccionInstitucion" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <input v-model="form.ciudad" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Ciudad">
                            <InputError :message="form.errors.ciudad" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Estado</label>
                            <input v-model="form.estado" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Estado">
                            <InputError :message="form.errors.estado" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tipo de Institución</label>
                            <select v-model="form.tipoInstitucion"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                                <option value=""> Selecciona una opción</option>
                                <option value="publica">Pública</option>
                                <option value="privada">Privada</option>
                            </select>
                            <InputError :message="form.errors.tipoInstitucion" />
                        </div>
                    </div>
                </section>

                <!-- Información de Contacto -->
                <section class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Información de Contacto</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono de Oficina</label>
                            <input v-model="form.telefonoOficina" type="tel"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Teléfono de oficina">
                            <InputError :message="form.errors.telefonoOficina" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Celular Particular</label>
                            <input v-model="form.celular" type="tel"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Número de celular">
                            <InputError :message="form.errors.celular" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Institucional</label>
                            <input v-model="form.emailInstitucional" type="email"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Correo institucional">
                            <InputError :message="form.errors.emailInstitucional" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Personal</label>
                            <input v-model="form.emailPersonal" type="email"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Correo personal">
                            <InputError :message="form.errors.emailPersonal" />
                        </div>
                    </div>
                </section>

                <!-- Información Académica -->
                <section class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Información Académica</h4>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Línea de Investigación</label>
                        <input v-model="form.lineaInvestigacion" type="text"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                            placeholder="Línea de investigación">
                        <InputError :message="form.errors.lineaInvestigacion" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nivel Educativo</label>
                        <input v-model="form.nivelEducativo" type="text"
                            class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                            placeholder="Nivel educativo del proyecto">
                        <InputError :message="form.errors.nivelEducativo" />
                    </div>
                </section>

                <!-- Credenciales de Usuario -->
                <section class="mb-6">
                    <h4 class="text-lg font-semibold mb-4">Credenciales de Usuario</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Usuario</label>
                            <input v-model="form.usuario" type="text"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Nombre de usuario">
                            <InputError :message="form.errors.usuario" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo</label>
                            <input v-model="form.correo" type="email"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md"
                                placeholder="Correo electrónico">
                            <InputError :message="form.errors.correo" />
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <input v-model="form.contrasena" type="password"
                                class="w-full mt-1 p-2 border border-gray-300 rounded-md" placeholder="Contraseña">
                            <InputError :message="form.errors.contrasena" />
                        </div>
                    </div>
                </section>

                <div v-if="isVisible"
                    class="fixed top-0 left-0 right-0 bottom-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full text-center">
                        <h3 class="text-xl font-semibold mb-4">¡Solicitud Enviada!</h3>
                        <p class="text-gray-600">Tu solicitud para unirte a la REIME está en revisión.</p>
                        <p class="text-gray-600">Se te notificará al correo una vez procesada.</p>
                        <button @click="closeMessage"
                            class="mt-4 px-6 py-2 bg-[#771139] text-white rounded-md hover:bg-[#5a0e2c]">
                            Cerrar
                        </button>

                    </div>
                </div>

                <!-- Botón de Enviar -->
                <button type="submit" class="w-full mt-4 p-3 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Registrar
                </button>
            </div>
        </form>
    </GuestLayout>
</template>