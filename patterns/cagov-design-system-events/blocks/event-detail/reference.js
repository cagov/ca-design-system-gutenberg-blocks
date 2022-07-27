
// REFERENCE

// Checks we need to do:
// -
// https://bebroide.medium.com/how-to-easily-develop-with-react-your-own-custom-fields-within-gutenberg-wordpress-editor-b868c1e193a9

// Sync date and time field with post custom field data.
// data.subscribe(function () {
//   var blocks = data.select("core/block-editor").getBlocks();

//   var isPostDirty = data.select("core/editor").isEditedPostDirty();
//   var isAutosavingPost = data.select("core/editor").isAutosavingPost();

//   if (isPostDirty && !isAutosavingPost) {
//     blocks.map((block) => {
//       if (block.name === "ca-design-system/cagov-event-detail") {
//         let eventDetailBlock = data
//           .select("core/block-editor")
//           .getBlocksByClientId(block.clientId);

//         console.log(eventDetailBlock);

//         eventDetailBlock.map((localBlock) => {
//           if (

//             localBlock.attributes !== undefined &&
//             localBlock.attributes.label !== null &&
//             // typeof updatedSelectedCategory[0].name === "string"
//           ) {
//             console.log("updating", localBlock);

//           }
//         });
//       }
//     });
//   }
// });
// https://developer.wordpress.org/block-editor/reference-guides/components/date-time/
// <OptionsExample {...props} />
// class OptionsExample extends Component {
//   constructor() {
//     super(...arguments);

//     this.state = {
//       exampleText: "",
//       isAPILoaded: false,
//     };
//   }

//   // https://developer.wordpress.org/block-editor/reference-guides/components/date-time/

//   componentDidMount() {

//     data.subscribe(() => {
//       const { exampleText } = this.state;

//       const isSavingPost = data.select("core/editor").isSavingPost();
//       const isAutosavingPost = data.select("core/editor").isAutosavingPost();

//       if (isAutosavingPost) {
//         return;
//       }

//       if (!isSavingPost) {
//         return;
//       }

//       const settings = new window.wp.api.models.Settings({
//         ["cagov_event_detail_example_text"]: exampleText,
//       });
//       settings.save();
//     });

//     // @TODO This is recommended in guide to this pattern ... but api not registered to window.wp

//     window.wp.api.loadPromise.then(() => {
//       this.settings = new window.wp.api.models.Settings();

//       const { isAPILoaded } = this.state;

//       // console.log("isAPILoaded", isAPILoaded);

//       if (isAPILoaded === false) {
//         this.settings.fetch().then((response) => {
//           // console.log("api response", response.cagov_event_detail_example_text);
//           this.setState({
//             exampleText: response.cagov_event_detail_example_text,
//             isAPILoaded: true,
//           }, () => console.log("set the state", this.state));
//         });
//       }
//     });
//   }

//   render() {
//     const { exampleText, isAPILoaded } = this.state;

//     const { setAttributes } = this.props;

//     // console.log("setAttributes", setAttributes);

//     if (!isAPILoaded) {
//       return (
//         <Placeholder>
//           <Spinner />
//         </Placeholder>
//       );
//     }

//     console.log(this.state);
//     return (
//       <Panel>
//         <PanelBody
//           title={__("Example Meta Box", "cagov_event_detail")}
//           icon="admin-plugins"
//         >
//           <TextControl
//             help={__("This is an example text field.", "cagov-event-detail")}
//             label={__("Example Text", "cagov_event_detail")}
//             onChange={(exampleText) => {
//               this.setState({ exampleText });
//               setAttributes({ exampleText });
//             }}
//             value={exampleText}
//           />
//         </PanelBody>
//       </Panel>
//     );
//   }
// }

// export default function Edit( props ) {
// 	return (
// 		<div { ...useBlockProps() }>
// 			<OptionsExample { ...props }/>
// 		</div>
// 	);
// }

// const onUpdateDate = ( dateTime ) => {
//   console.log("dateTime", dateTime);
//   var newDateTime = moment(dateTime).format( 'YYYY-MM-DD HH:mm' );
//   setAttributes( { datetime: newDateTime } );
// };

{
    /* <RichText
                value={startDate}
                tagName="div"
                className="startDate"
                value={startDate}
                onChange={(startDate) => props.setAttributes({ startDate })}
                placeholder={__(formattedDate, "ca-design-system")}
              /> 
              
              <RichText
                value={endDate}
                tagName="div"
                className="endDate"
                value={endDate}
                onChange={(endDate) => props.setAttributes({ endDate })}
                placeholder={__(formattedDate, "ca-design-system")}
              />
  
              <RichText
                value={startTime}
                tagName="div"
                className="startTime"
                value={startTime}
                onChange={(startTime) => props.setAttributes({ startTime })}
                placeholder={__(formattedTime, "ca-design-system")}
              />
  
              <RichText
                value={endTime}
                tagName="div"
                className="endTime"
                value={endTime}
                onChange={(endTime) => props.setAttributes({ endTime })}
                placeholder={__(formattedTimePlusHour, "ca-design-system")}
              /> */