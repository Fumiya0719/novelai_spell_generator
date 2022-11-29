// 汎用的なType/Interface
export type Nsfw = 'A' | 'B' | 'C' | 'D' | 'Z'

export interface ColorVariation {
    prompt: string,
    jp: string,
}

// Prompt関連のInterface
export interface Prompt {
    id: number,
    tag: string,
    slag: string,
    jp: string,
    parentTag: string,
    display: boolean,
    selected: boolean,
    nsfw: Nsfw,
    variation: null | 'CC' | 'CM',
    index: string | null,
    detail: string | null
}         
export interface SetPrompt extends Prompt {
    output_prompt: string,
    enhance: number,
    color_list: ColorVariation[] | null
}

export interface PromptList {
    slag: string,
    jp: string,
    caption: string | null,
    nsfw: Nsfw,
    display: boolean,
    show_all: boolean,
    content: Prompt[],
}

// Preset関連のInterface
export interface Preset {
    preset_id: number | null,
    image: string | ArrayBuffer | null,
    imagePath: string | null,
    from: string,
    commands: string | null,
    commands_ban: string | null,
    description: string | null,
    nsfw: Nsfw,
    seed: string,
    resolution_width: string | number | null,
    resolution_height: string | number | null,
    resolution: string | null,
    model: string | null,
    sampling: number | null,
    sampling_algo: string | null,
    scale: number | null,
    options: any,
    others: string,
}

export interface PresetDetail extends Preset {
    index: number,
    thumbnail: string,
    nsfw_display: '全年齢' | 'R-15' | 'R-18',
}

export interface SearchData {
    age: string[],
    item: string[],
    word: string,
    sort: string,
    order: string,
}

