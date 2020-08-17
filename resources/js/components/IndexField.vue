<template>
    <div>
        <img
            alt=""
            :class="{ 'rounded-full': field.rounded, rounded: !field.rounded }"
            :src="img"
            class="align-bottom w-8 h-8 sb-img-mx"
            style="object-fit: cover;"
            v-for="img in images"
        />

        <small class="sb-images-num" v-if="number > 0">+{{ number }}</small>
    </div>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    computed: {
        images() {
            return this.field.thumbnailUrl.slice(0, 3)
        },
        number() {
            return this.field.thumbnailUrl.length - this.images.length
        }
    }
}
</script>
