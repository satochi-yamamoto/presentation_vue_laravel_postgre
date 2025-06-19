<template>
  <section id="experience" class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-center mb-12 dark:text-white">Experiência Profissional</h2>
      
      <div v-if="loading" class="flex justify-center">
        <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
      </div>
      
      <div v-else-if="error" class="text-center text-red-500">
        {{ error }}
      </div>
      
      <div v-else class="timeline relative max-w-4xl mx-auto">
        <div v-for="(exp, index) in experiences" :key="exp.id" 
             class="timeline-item mb-12 relative pl-16 group">
          <div class="timeline-date absolute left-0 top-0 bg-blue-600 text-white 
                      px-4 py-2 rounded-lg font-medium shadow-md transition-all
                      group-hover:bg-blue-700 group-hover:scale-105">
            {{ formatDate(exp.start_date) }} - {{ exp.is_current ? 'Presente' : formatDate(exp.end_date) }}
            <span class="block text-xs font-normal opacity-80">{{ exp.duration }}</span>
          </div>
          
          <div class="timeline-content bg-white dark:bg-gray-700 p-6 rounded-lg 
                      shadow-md transition-all hover:shadow-lg hover:-translate-y-1">
            <h3 class="text-xl font-bold text-blue-800 dark:text-blue-400">{{ exp.company }}</h3>
            <h4 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ exp.position }}</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ exp.description }}</p>
            
            <ul v-if="exp.responsibilities" class="list-disc pl-5 text-gray-600 dark:text-gray-400">
              <li v-for="(resp, i) in exp.responsibilities" :key="i">{{ resp }}</li>
            </ul>
            
            <div v-if="isAdmin" class="mt-4 flex gap-2">
              <button @click="editExperience(exp)" class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded">
                Editar
              </button>
              <button @click="deleteExperience(exp.id)" class="text-sm bg-red-100 text-red-800 px-3 py-1 rounded">
                Excluir
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useExperienceStore } from '@/stores/experienceStore';
import { useAuthStore } from '@/stores/authStore';

const experienceStore = useExperienceStore();
const authStore = useAuthStore();

const { experiences, loading, error, fetchExperiences } = experienceStore;
const isAdmin = authStore.isAuthenticated;

onMounted(() => {
  fetchExperiences();
});

const formatDate = (dateString) => {
  if (!dateString) return '';
  const date = new Date(dateString);
  return date.toLocaleDateString('pt-BR', { month: 'short', year: 'numeric' });
};

const editExperience = (exp) => {
  // Abrir modal de edição
  console.log('Edit:', exp);
};

const deleteExperience = async (id) => {
  if (confirm('Tem certeza que deseja excluir esta experiência?')) {
    try {
      await axios.delete(`/experiences/${id}`);
      await fetchExperiences();
    } catch (err) {
      console.error('Error deleting experience:', err);
    }
  }
};
</script>

<style scoped>
.timeline::before {
  content: '';
  position: absolute;
  top: 0;
  left: 35px;
  height: 100%;
  width: 2px;
  background: #3b82f6;
}

.timeline-item::before {
  content: '';
  position: absolute;
  left: 30px;
  top: 20px;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #3b82f6;
  border: 2px solid white;
  z-index: 1;
}

.dark .timeline-item::before {
  border-color: #1f2937;
}

.dark .timeline::before {
  background: #4b5563;
}
</style>