<template>
    <panel-item :field="field">
        <div class="sb-field-images" slot="value">
            <div :key="index" v-for="img in this.field.previewUrl">
                <img
                    alt=""
                    :class="{ 'rounded-full': field.rounded, rounded: !field.rounded }"
                    :src="img"
                />

                <p class="flex pt-2 mb-4 items-center text-sm">
                    <a
                        :dusk="field.attribute + '-download-link'"
                        :href="img"
                        class="cursor-pointer dim btn btn-link text-primary inline-flex items-center"
                        tabindex="0"
                        target="_blank"
                        v-if="field.downloadable"
                    >

                        <icon
                            class="mr-2"
                            height="16"
                            type="download"
                            view-box="0 0 24 24"
                            width="16"
                        />

                        <span class="class mt-1">{{ __('Download') }}</span>
                    </a>
                </p>
            </div>
        </div>
    </panel-item>
</template>

<script>
export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
}
</script>
