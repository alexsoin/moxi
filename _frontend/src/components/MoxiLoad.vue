<template>
	<svg
		viewBox="0 0 24 24"
		xmlns="http://www.w3.org/2000/svg"
		fill="currentColor"
	>
		<path d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,20a9,9,0,1,1,9-9A9,9,0,0,1,12,21Z" />
		<rect
			class="spinner spinner__hour"
			x="11"
			y="6"
			rx="1"
			width="2"
			height="7"
		/>
		<rect
			class="spinner spinner__minute"
			x="11"
			y="11"
			rx="1"
			width="2"
			height="9"
		/>
	</svg>
</template>

<style lang="scss" scoped>
.spinner {
	transform-origin: center;

	&__hour {
		animation: animate-spinner 9s linear infinite;
	}

	&__minute {
		animation: animate-spinner .75s linear infinite;
	}
}

@keyframes animate-spinner {
	100% {
		transform:rotate(360deg)
	}
}
</style>
