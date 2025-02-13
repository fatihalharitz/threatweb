<script setup>
// Define all props using defineProps
const props = defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    url: {
        type: String,
        required: true,
    },
    cveID:{
        type: String,
        required: true,
    }
});

// Redirect method
const redirect = () => {
    window.open(props.url + props.cveID, '_blank');
};
</script>

<template>
    <button
        @click="redirect"
        :type="type"
        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-50 transition ease-in-out duration-150"
    >
        <slot />
    </button>
</template>
