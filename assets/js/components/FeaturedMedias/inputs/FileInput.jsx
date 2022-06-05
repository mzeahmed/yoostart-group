export default function FileInput ({ handleChange, inputs }) {
  return (
    <input
      type="file"
      name="featured_image"
      className="ys-group-post-featured-img-file"
      value={inputs.featured_image}
      onChange={handleChange}
    />
  );
}