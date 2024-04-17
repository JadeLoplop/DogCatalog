<script setup>
import { onMounted, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ToastMessage from '@/Components/ToastMessage.vue';
import { Head } from '@inertiajs/vue3';
import Swiper from 'swiper';
import axios from 'axios';

const { users, dogImgs } = defineProps({
    users: {
        type: Array,
    },

    dogImgs: {
        type: Array,
    },
})

const showModal = ref(false);
const likedImages = ref([]);
const selectedUser = ref({});
const selectedUserLikedImages = ref([]);

const initSwiper = () => {
    // Initialize Swiper for the user carousel
    new Swiper('.swiper-container', {
        // Optional parameters
        loop: true,
        slidesPerView: 'auto',
        centeredSlides: true,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
};

const handleSlideClick = async (user_id) => {

    const endpoint = `/user-liked-images/${user_id}`
    const response = await axios.get(endpoint);


    selectedUser.value = response.data.data.user;
    selectedUserLikedImages.value = response.data.data.imgUrls

    console.log('Response:', response.data);

    showModal.value = true;
}

const handleLikeDog = async (imgUrl, onUserSection) => {
    try {
        const payload = {
            imgUrl: imgUrl
        }
        const response = await axios.post('/like-image', payload);

        if (response.data.action) {
            if (response.data.action == 'like') {
                if (onUserSection) {
                    selectedUserLikedImages.value.push(imgUrl);
                } else {
                    likedImages.value.push(imgUrl);
                }

            } else {
                if (onUserSection) {
                    selectedUserLikedImages.value.splice(selectedUserLikedImages.value.indexOf(imgUrl), 1);
                } else {
                    likedImages.value.splice(likedImages.value.indexOf(imgUrl), 1);
                }
            }
        } else {
            showToastMessage(response.data.error, 'error')
        }
    } catch (error) {
        showToastMessage(error.response.data.error, 'error')
    }
}

const isLiked = (imgUrl) => {
    return likedImages.value.includes(imgUrl);
}

let showToast = false;
let toastMessage = '';
let toastType = 'info';

const showToastMessage = (message, type = 'info') => {
    console.log('hasdasdasd');
  toastMessage = message;
  toastType = type;
  showToast = true;
};

const fetchUserLikeImages = async () => {
    const response = await axios.get('/liked-images');

    if (response.data.data) {
        likedImages.value = response.data.data;
    }

}

const fetchRandomImg = async () => {
    let userCount = users.length;
    try {
        const response = await axios.get(`https://randomuser.me/api/?results=${userCount}`);
        const profileImages = response.data.results.map(user => user.picture.large);
        users.forEach((user, index) => {
            // Update the profile image for each user in the existing array
            user.picture = profileImages[index];
        });
    } catch (error) {
        console.error('Error fetching profile images:', error);
    }

}

onMounted(() => {
    initSwiper();
    fetchRandomImg();
    fetchUserLikeImages();
});

</script>

<template>
    <ToastMessage v-if="showToast" :message="toastMessage" :type="toastType" />
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Users with their liked images.</div>
                    <div class="swiper-container text-center">
                        <div class="swiper-wrapper" style="display: flex; flex-direction: row;">
                            <div v-for="user in users" :key="user.id" class="swiper-slide"
                                @click="handleSlideClick(user.id)">
                                <div class="p-6">
                                    <img :src="user.picture" alt="User Profile">
                                    {{ user.name }}
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">Random Images.</div>
                    <ul class="grid grid-cols-3 gap-4 p-6">
                        <li v-for="(img, index) in dogImgs" :key="index"
                            class="bg-gray-200 rounded-lg relative overflow-hidden">
                            <img :src="img" alt="Dog Image" class="w-full h-full object-cover"
                                style="aspect-ratio: 1/1;">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-50 hover:bg-opacity-75 flex justify-center items-center opacity-0 transition-opacity duration-300">
                                <button type="button" @click="handleLikeDog(img, false)"
                                    :class="{ 'text-red-500': isLiked(img) }"
                                    class="text-white text-4xl">&hearts;</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 overflow-y-auto z-50 flex items-center justify-center">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white p-8 max-w-xl w-full mx-auto rounded-lg z-50">

                <div class="modal-content">
                    <div class="user-info mb-8">
                        <h2 class="text-lg font-semibold">User Info</h2>
                        <p>User name: {{ selectedUser.name }}</p>
                        <p>Email: {{ selectedUser.email }}</p>
                    </div>

                    <div class="image-section grid grid-cols-3 gap-4">
                        <!-- Display images if available -->
                        <template v-if="selectedUserLikedImages.length > 0">
                            <div v-for="(imageUrl, index) in selectedUserLikedImages" :key="index" class="relative">
                                <div class="hover:bg-gray-200 cursor-pointer">
                                    <img :src="imageUrl" :alt="'Image ' + (index + 1)" class="w-full h-auto" >
                                </div>
                                <!-- Black backdrop and heart icon overlay -->
                                <div  @click="handleLikeDog(imageUrl, true)"
                                    class="absolute inset-0 flex justify-center items-center bg-black bg-opacity-50 opacity-0 transition-opacity duration-300 hover:opacity-100 cursor-pointer">
                                    <svg v-bind:class="{ 'text-red-500': isLiked(imageUrl) }" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white fill-current"
                                        viewBox="0 0 20 20">
                                        <path
                                            d="M10 18l-1.45-1.32C3.4 11.27 0 8.35 0 5.5 0 2.42 2.42 0 5.5 0 7.09 0 8.59.62 10 2.06 11.41.62 12.91 0 14.5 0 17.58 0 20 2.42 20 5.5c0 2.85-3.4 5.77-8.55 11.18L10 18z" />
                                    </svg>
                                </div>
                            </div>
                        </template>
                        <!-- Display "No image available" text if no images available -->
                        <template v-else>
                            <p class="col-span-3 text-center text-gray-500">No image available</p>
                        </template>
                    </div>

                    <button @click="showModal = false"
                        class="right-0 mt-4 mr-4 px-3 py-1 text-sm text-gray-500 bg-gray-200 rounded-lg focus:outline-none hover:bg-red-300">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
li {
    position: relative;
}

li:hover .absolute {
    opacity: 1;
}

.swiper-slide:hover {

    transform: scale(1.05);
    transition: transform 0.3s ease;
    cursor: pointer;
}
</style>
