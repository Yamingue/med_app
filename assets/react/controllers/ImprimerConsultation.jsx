import React, { useRef } from 'react';
import { useReactToPrint } from 'react-to-print';
export default function (props) {
    const componentRef = useRef();
    const handlePrint = useReactToPrint({
        content: () => componentRef.current,
    });
    let { patient, type, consultation } = props;
    patient = JSON.parse(patient)
    consultation = JSON.parse(consultation)
    const createdDate = new Date(consultation.create_at)

    var dateJS = new Date(patient.ne_le);

    // Obtenir les composants de la date (jour, mois et année)
    var jour = dateJS.getUTCDate();
    var mois = dateJS.getUTCMonth() + 1; // Ajoutez 1 car les mois sont indexés à partir de 0
    var annee = dateJS.getUTCFullYear();
    var dateFormatee = jour.toString().padStart(2, '0') + '-' + mois.toString().padStart(2, '0') + '-' + annee;
    console.log(consultation)
    return <>
        <div className="d-flex justify-content-between">
        <a href={props.locationBack} className='btn btn-primary mb-2' onClick={handlePrint}>Retour</a>
        <button className='btn btn-primary mb-2' onClick={handlePrint}>Print this out!</button>
        </div>
        <div className="card" ref={componentRef}>
            <div className="card-body">
                <div className="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column p-sm-3 p-0">
                    <div className="mb-xl-0 mb-4">
                        <div className="d-flex svg-illustration mb-3 gap-2">
                            <span className="app-brand-text demo text-body fw-bold">Nom Hopital</span>
                        </div>
                        <p className="mb-1">Quartier, ville</p>
                        <p className="mb-0">+235 66 66 66 66/ 99 99 99 99</p>
                    </div>
                    <div>
                        <h4>#{consultation.id}</h4>
                        <div className="mb-2">
                            <span className="me-1">Date:</span>
                            <span className="fw-medium">{createdDate.getUTCDate().toString().padStart(2, '0') + '-' + (createdDate.getUTCMonth() + 1) + '-' + createdDate.getUTCFullYear()}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr className="my-0" />
            <div className="card-body">
                <div className="row p-sm-3 p-0">
                    <div className="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                        <h6 className="pb-2">Information du patient</h6>
                        <p className="mb-1">{patient.nom}</p>
                        <p className="mb-1">{patient.prenom}</p>
                        <p className="mb-0">{dateFormatee}</p>
                    </div>
                    <div className="col-xl-6 col-md-12 col-sm-7 col-12">
                        <h6 className="pb-2">Information sur la consultation.</h6>
                        <table>
                            <tbody>
                                <tr>
                                    <td className="pe-3">Montant:</td>
                                    <td>$12,110.55</td>
                                </tr>
                                <tr>
                                    <td className="pe-3">Type:</td>
                                    <td>{type}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div className="table-responsive">
                {/* <table className="table border-top m-0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Cost</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td className="text-nowrap">Vuexy Admin Template</td>
                            <td className="text-nowrap">HTML Admin Template</td>
                            <td>$32</td>
                            <td>1</td>
                            <td>$32.00</td>
                        </tr>
                        <tr>
                            <td className="text-nowrap">Frest Admin Template</td>
                            <td className="text-nowrap">Angular Admin Template</td>
                            <td>$22</td>
                            <td>1</td>
                            <td>$22.00</td>
                        </tr>
                        <tr>
                            <td className="text-nowrap">Apex Admin Template</td>
                            <td className="text-nowrap">HTML Admin Template</td>
                            <td>$17</td>
                            <td>2</td>
                            <td>$34.00</td>
                        </tr>
                        <tr>
                            <td className="text-nowrap">Robust Admin Template</td>
                            <td className="text-nowrap">React Admin Template</td>
                            <td>$66</td>
                            <td>1</td>
                            <td>$66.00</td>
                        </tr>
                        <tr>
                            <td colspan="3" className="align-top px-4 py-5">
                                <p className="mb-2">
                                    <span className="me-1 fw-medium">Salesperson:</span>
                                    <span>Alfie Solomons</span>
                                </p>
                                <span>Thanks for your business</span>
                            </td>
                            <td className="text-end px-4 py-5">
                                <p className="mb-2">Subtotal:</p>
                                <p className="mb-2">Discount:</p>
                                <p className="mb-2">Tax:</p>
                                <p className="mb-0">Total:</p>
                            </td>
                            <td className="px-4 py-5">
                                <p className="fw-medium mb-2">$154.25</p>
                                <p className="fw-medium mb-2">$00.00</p>
                                <p className="fw-medium mb-2">$50.00</p>
                                <p className="fw-medium mb-0">$204.25</p>
                            </td>
                        </tr>
                    </tbody>
                </table> */}
            </div>
        </div>
    </>;
}
