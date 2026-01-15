import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import './editor.scss';

registerBlockType('ai-test/sample-block', {
    edit: ({ attributes, setAttributes }) => {
        const blockProps = useBlockProps();

        return (
            <div {...blockProps}>
                <RichText
                    tagName="p"
                    value={attributes.message}
                    onChange={(message) => setAttributes({ message })}
                    placeholder="Enter your message..."
                />
            </div>
        );
    },
    save: ({ attributes }) => {
        const blockProps = useBlockProps.save();

        return (
            <div {...blockProps}>
                <RichText.Content tagName="p" value={attributes.message} />
            </div>
        );
    },
});
