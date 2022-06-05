import Content from './parts/Content';
import FeaturedImage from './parts/FeaturedImage';

export default function PostContent ({ content, featured_image, title }) {
  return (
    <div className="post-content">
      <Content content={content}/>
      <FeaturedImage featured_image={featured_image} title={title}/>
    </div>
  );
}