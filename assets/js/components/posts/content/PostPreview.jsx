import PostFooter from '../footer/PostFooter';
import PostHeader from '../header/PostHeader';
import PostContent from './PostContent';

export default function PostPreview ({ ...post }) {
  return (
    <>
      <PostHeader {...post} />
      <PostContent {...post} />
      <PostFooter {...post} />
    </>
  );
}