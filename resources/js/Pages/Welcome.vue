<script setup>
    import { Head, Link } from '@inertiajs/vue3';
    defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Welcome" />
    <div
        class="sm:flex sm:justify-center sm:items-center min-h-screen bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-orange-500 selection:text-black">
        <!--Log-in and Register Button-->
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            <!--If user already logged-in-->
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link>
               
            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >
                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-black focus:outline focus:outline-2 focus:rounded-sm focus:outline-orange-500"
                    >Register</Link
                >
            </template>
        </div>
        <div class="max-w-7xl mx-auto p-5 lg:p-8">
                    <h3 className='text-4xl md:text-8xl text-black
                    font-bold py-5 text-center'>
                        Agenda
                    </h3>
                    <div className='text-4xl md:text-8xl text-black
                    font-bold py-5 text-center'>
                        <img class="center" style="width: 50%; height: 20%; margin-left: 200px;" :src="image">
                    </div>
            
        </div>
    </div>
</template>


<style>
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-color: whitesmoke;
    }
}
</style>

<script>
export default {
    data() {
        return {
            image: '/images/Agenda.png'
        }
    }
};
</script>
