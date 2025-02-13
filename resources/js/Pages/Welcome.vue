<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            vulnerabilites: [],
            loading: true,
            error: null,
        };
    },
    mounted() {
        this.fetchVulnerabilites();
    },
    methods:{
        async fetchVulnerabilites(){
            try{
                const response = await axios.get('http://localhost:8000/api/vulnerabilites');
                if(response.status === 200){
                    this.vulnerabilites = response.data.vulnerabilites;
                    console.log(this.vulnerabilites);
                }
            }catch(error){
                this.error = 'Failed to fetch data';
                console.error ('Error fetching data', error);
            }finally {
                this.loading = false;
            }

        }
    }
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-stone-900 dark:text-white/50">
         <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-screen max-w-screen-xl">
                <header class="flex flex-row items-center justify-between py-6 bg-stone-900 px-6 border-b-2 border-stone-700">
                    <div class="flex">
                        <h1 class="text-2xl text-emerald-400 font-light">Lorem Ipsum</h1>
                    </div>
                    <nav v-if="canLogin" class="">

                    </nav>
                </header>

                <main class="mt-10">
                    <div>
                        <form @submit.prevent="submitSearch" class="flex flex-row justify-center items-center gap-6">
                            <input
                                type="text"
                                v-model="searchQuery"
                                placeholder="Find..."
                                class="bg-stone-200 text-black px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-emerald-600 w-1/2"
                            />
                            <PrimaryButton>
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z"/></svg>
                            </PrimaryButton>
                        </form>
                    </div>

                    <div class="flex flex-col mt-10 mx-20 gap-8">

    <!--                        Card per CVE-->
                        <div class="flex flex-col gap-2 bg-stone-800 p-8 rounded-2xl border-2 border-stone-800 hover:border-2 hover:border-stone-700">
                           <div class="flex flex-row justify-between">
                               <h1 class="text-white font-bold text-3xl hover:text-stone-300">
                                    {{vulnerabilites}}
                               </h1>
                               <PrimaryButton>
                                   <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
                               </PrimaryButton>
                           </div>
                            <h1 class="text-emerald-600">
<!--                                {{vulnerabilites[0].vendorProject}}-->
                            </h1>
                            <h2 class="text-stone-300">
<!--                                {{vulnerabilites[0].dateAdded}}-->
                            </h2>
                            <p class="text-stone-300">
<!--                                {{vulnerabilites[0].shortDescription}}-->
                            </p>
                            <Link class="text-emerald-600">
                                see poc
                            </Link>
                            <Link class="text-emerald-600">
                                see latest news
                            </Link>
                        </div>


                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">

                </footer>
            </div>
        </div>
    </div>
</template>
