<script setup lang="ts">
defineProps<{
	modelValue: string,
	label: string,
	note?: string,
	placeholder?: string,
}>();
const emit = defineEmits(["update:modelValue"]);

const updateValue = (e: Event) => {
	emit("update:modelValue", (e.target as HTMLInputElement).value);
};
</script>

<template>
	<label class="flex flex-col gap-1">
		<div class="flex flex-row justify-between items-end gap-5">
			<span>{{ label }}:</span>
			<small
				v-if="note"
				class="opacity-70 text-orange-200"
			>{{ note }}</small>
		</div>
		<input
			:value="modelValue"
			:placeholder="placeholder || ''"
			type="text"
			class="border-2 border-gray-500 bg-gray-600 rounded px-4 py-2 outline-none focus:border-orange-300"
			@input="updateValue"
		>
	</label>
</template>
