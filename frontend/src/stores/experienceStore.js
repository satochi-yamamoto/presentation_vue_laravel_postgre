import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from '@/api/axios';

export const useExperienceStore = defineStore('experience', () => {
    const experiences = ref([]);
    const loading = ref(false);
    const error = ref(null);

    const fetchExperiences = async () => {
        try {
            loading.value = true;
            const response = await axios.get('/experiences');
            experiences.value = response.data;
        } catch (err) {
            error.value = err.message;
            console.error('Error fetching experiences:', err);
        } finally {
            loading.value = false;
        }
    };

    return { experiences, loading, error, fetchExperiences };
});