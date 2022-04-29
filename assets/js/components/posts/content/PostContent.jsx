import FeaturedImage from '../parts/FeaturedImage';
import Content from '../parts/Content';

export default function PostContent({content, postFeaturedImage, postTitle}) {
    return (
        <div className="post-content">
            <Content content={content}/>
            <FeaturedImage postFeaturedImage={postFeaturedImage} postTitle={postTitle}/>
        </div>
    );
}