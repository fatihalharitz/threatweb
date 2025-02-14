<script setup>
import { Head } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import LinkButton from "@/Components/LinkButton.vue";
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-stone-900 dark:text-white/50">
         <div class="relative min-h-screen flex flex-col items-center justify-between selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-screen max-w-screen-xl">

<!--                HEADER-->
                <header class="flex flex-row items-center justify-between py-6 bg-stone-900 px-6 border-b-2 border-stone-700">
                    <div class="flex">
                        <h1 class="text-2xl text-emerald-400 font-medium">Threat Web</h1>
                    </div>
<!--                    <nav v-if="canLogin" class="">-->
<!--                    </nav>-->
                </header>

<!--                MAIN-->
                <main class="mt-10">

<!--                    Data information Status-->
                    <div>
                        <div class="mx-32 px-14 py-6 bg-stone-800 flex flex-row rounded-2xl">
                            <div class="w-full flex flex-col gap-2">
                                <h1 class="text-emerald-500 font-medium text-medium">Data Source</h1>
                                <h1 class="text-emerald-500 font-medium text-medium">Version</h1>
                                <h1 class="text-emerald-500 font-medium text-medium">Release Date</h1>
                                <h1 class="text-emerald-500 font-medium text-medium">Total Data</h1>
                            </div>
                            <div class="w-full flex flex-col gap-2">
                                <h1 class="text-medium">{{ catalogSource }}</h1>
                                <h1 class="text-medium">{{ catalogVersion }}</h1>
                                <h1 class="text-medium">{{ catalogDateReleased }}</h1>
                                <h1 class="text-medium">{{ catalogCount }}</h1>
                            </div>
                        </div>
                    </div>

<!--                    search bar-->
                    <div class="mt-10">
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


<!--                    Card Container-->
                    <div class="flex flex-col mt-10 mx-20 gap-8">

                        <!-- Card per CVE-->
                        <div v-for="vulnerability in vulnerabilites" :key="vulnerability.cveID" class="flex flex-col gap-3 bg-stone-800 p-8 rounded-2xl border-2 border-stone-800 hover:border-2 hover:border-stone-700">
                           <h1 class="text-white font-bold text-3xl">
                                {{vulnerability.vulnerabilityName}}
                           </h1>
                            <h1 class="text-emerald-600 font-bold">
                                {{vulnerability.cveID}}
                            </h1>
                            <h1 class="text-emerald-600 font-bold">
                                {{vulnerability.cwes}}
                            </h1>
                            <h2 class="text-stone-300">
                                <strong>Vendor Project: </strong>
                                {{vulnerability.vendorProject}}
                            </h2>
                            <h2 class="text-stone-300">
                                <strong>Product: </strong>
                                {{vulnerability.product}}
                            </h2>
                            <h2 class="text-stone-300">
                                <strong>Date Added: </strong>
                                {{vulnerability.dateAdded}}
                            </h2>
                            <p class="text-stone-300">
                                <strong>Short Description: </strong>
                                {{vulnerability.shortDescription}}
                            </p>
                            <p class="text-stone-300">
                                <strong>Mitigation: </strong>
                                {{vulnerability.requiredAction}}
                            </p>
                            <a class="text-emerald-600 hover:text-emerald-500" :href="pocUrl + vulnerability.cveID + pocUrlEnd" target="_blank" rel="noopener noreferrer">
                                See Poc
                            </a>
                            <a class="text-emerald-600 hover:text-emerald-500" :href="newsUrl + vulnerability.vulnerabilityName +' '+ vulnerability.cveID" target="_blank" rel="noopener noreferrer">
                                See Latest News
                            </a>
                            <div class="flex flex-row mt-6 gap-5">
                                <LinkButton url="https://www.cve.org/CVERecord?id=" :cveID="vulnerability.cveID" target="_blank" rel="noopener noreferrer">
                                    See CVE Details
                                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>
                                </LinkButton>
                            </div>
                        </div>
<!--                        End of CVE Card-->

                    </div>
                </main>

<!--                <footer class="py-16 text-center text-sm text-black dark:text-white/70">-->
<!--                        -->
<!--                </footer>-->
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return {
            cwe: [],
            newsUrl:'',
            pocUrl: '',
            pocUrlEnd: '',
            vulnerabilites: [],
            catalogSource: '',
            catalogVersion: '',
            catalogDateReleased: '',
            catalogCount: '',
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
                    this.vulnerabilites = response.data.vulnerabilities;
                    this.catalogSource = response.data.title;
                    this.catalogVersion = response.data.catalogVersion;
                    this.catalogDateReleased = response.data.dateReleased;

                    this.catalogCount = response.data.count;
                    this.pocUrl = "https://github.com/search?q="
                    this.pocUrlEnd = "+in:file"
                    this.newsUrl = "https://news.google.com/search?q="
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
