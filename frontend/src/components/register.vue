<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-cover">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-bold mb-8 text-center">
          Alta de nou usuari
        </h1>
        <form id="formulariregistre" @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-gray-700" for="email">Email</label>
            <input
              id="email"
              v-model="email"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="email"
              required
              placeholder="Email"
            >
          </div>
          <div class="mb-4">
            <label class="block text-gray-700" for="password">Contrasenya</label>
            <input
              id="password"
              v-model="password"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="password"
              required
              placeholder="Contrasenya"
            >
          </div>
  
          <div class="mb-4">
            <label class="block text-gray-700" for="passwordRepeat">Repeteix contrasenya</label>
            <input
              id="passwordRepeat"
              v-model="passwordRepeat"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="password"
              required
              placeholder="Repeteix contrasenya"
            >
          </div>
  
          <div class="mb-4">
            <label class="block text-gray-700" for="nom">Nom</label>
            <input
              id="nom"
              v-model="nom"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="text"
              required
              placeholder="Nom"
            >
          </div>
  
          <div class="mb-4">
            <label class="block text-gray-700" for="cognoms">Cognoms</label>
            <input
              id="cognoms"
              v-model="cognoms"
              class="form-input mt-1 block w-full h-12 rounded px-4 border border-gray-300"
              type="text"
              required
              placeholder="Cognoms"
            >
          </div>         
  
          <button
            class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700 w-full mb-4"
            type="submit"
          >
            Registre d'usuari
          </button>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios' // Importa Axios per a realizar sol·licituds
  
  export default {
    /**
   * @name RegistreUsuari
   * @description pàgina que gestiona el registre d'un nou usuari en el sistema. Permet a l'usuari
   * introduir les seves dades, validar les contrasenyes i enviar les dades al servidor per completar
   * el registre.
   */
    data () {
      /**
     * @data
     * @description Dades reactives per emmagatzemar les entrades de l'usuari durant el registre.
     * Inclou informació com el correu electrònic, contrasenya, nom, cognoms, etc.
     */
      return {
        email: '',
        password: '',
        passwordRepeat: '', // Añadir esta línea para almacenar la contraseña repetida
        nom: '',
        cognoms: '',
      }
    },
    methods: {
      /**
     * @method submit
     * @description Mètode que s'executa quan l'usuari envia el formulari de registre.
     * Comprova que les contrasenyes coincideixen i envia les dades al servidor per registrar l'usuari.
     * Si el registre és exitós, es reseteja el formulari.
     */
      async submit () {
        // Validar que las contraseñas coinciden
        if (this.password !== this.passwordRepeat) {
          alert('Les contrasenyes no coincideixen. Si us plau, intenta-ho de nou.')
          return // No enviar la solicitud si las contraseñas no coinciden
        }
  
        try {
          const baseURL = "http://localhost:8088"
          const response = await axios.post(`${baseURL}/api/register`, {
            nom: this.nom,
            cognoms: this.cognoms,
            email: this.email,
            password: this.password, // Solo se envía la contraseña
            password_confirmation: this.passwordRepeat, // Añadido para confirmar la contraseña
          
        })
  
          if (response.status === 201) {
            alert('Usuari registrat amb èxit!')
            document.getElementById('formulariregistre').reset()
          }
        } catch (error) {
          console.error(error.response?.data);  // Esto imprimirá los detalles del error
          alert(`Error de registre: ${error.response?.data.error || error.message}`)
        }
      }
    }
  }
  </script>
  
  <style scoped>
  </style>