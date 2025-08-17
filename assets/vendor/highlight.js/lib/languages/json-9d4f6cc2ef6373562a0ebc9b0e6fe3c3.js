/**
 * Bundled by jsDelivr using Rollup v2.79.2 and Terser v5.39.0.
 * Original file: /npm/highlight.js@11.9.0/es/languages/json.js
 *
 * Do NOT use SRI with dynamically generated files! More information: https://www.jsdelivr.com/using-sri-with-dynamic-files
 */
function e(e){const a=["true","false","null"],n={scope:"literal",beginKeywords:a.join(" ")};return{name:"JSON",keywords:{literal:a},contains:[{className:"attr",begin:/"(\\.|[^\\"\r\n])*"(?=\s*:)/,relevance:1.01},{match:/[{}[\],:]/,className:"punctuation",relevance:0},e.QUOTE_STRING_MODE,n,e.C_NUMBER_MODE,e.C_LINE_COMMENT_MODE,e.C_BLOCK_COMMENT_MODE],illegal:"\\S"}}export{e as default};
