<template>
    <div>
        <img
            alt=""
            :class="{ 'rounded-full': field.rounded, rounded: !field.rounded }"
            :src="img"
            class="align-bottom w-8 h-8 sb-img-mx"
            style="object-fit: cover;"
            v-for="(img, index) in field.thumbnailUrl"
        />
    </div>
</template>

<script>
    export default {
        props: ['resourceName', 'field'],
    }
</script>
