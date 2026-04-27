export const hacketText = (text) => {
    const hacketText = text.replace(/\s/g, "_").toUpperCase();
    return hacketText;
}