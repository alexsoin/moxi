import { IParams } from "@/types/params.type";
import { Step } from "@/types/step.type";

interface IRes {
	success: boolean;
	message?: string;
	data?: any;
}

export interface ILogResponse {
	error: string[];
	info: string[];
	warning: string[];
}

interface IApiResponse extends IRes {
	data?: {
		params: IParams;
		steps: Step[];
	};
	log?: ILogResponse;
}

export type ApiResponse = IApiResponse | undefined
