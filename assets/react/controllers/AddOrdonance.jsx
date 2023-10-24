import React, { useRef } from 'react'


export default function ({ id = -1, url }) {
    console.log(id)
    const [medicament, setMedicament] = React.useState([])
    const [sending, setSending] = React.useState(false)
    const [ordonance, setOrdonance] = React.useState([

    ])
    const query = (data) => {
        if (data.target.value != "") {
            fetch('/api/ordonnance', {
                method: 'POST',
                body: JSON.stringify({
                    "query": data.target.value
                })
            }).then(d => d.json())
                .then(json => {
                    console.log(json)
                    setMedicament(json)
                })
        } else {
            setMedicament([])
        }
    }

    const addMeds = (med) => {
        let meds = ordonance.filter(e => e.id != med.id)
        setOrdonance([...meds, med])
    }

    const removeMed = (med) => {
        let meds = ordonance.filter(e => e.id != med.id)
        setOrdonance([...meds])
    }

    const sendOrdonnance = () => {
        setSending(true)
        fetch('/api/ordonnace/consultation/' + id, {
            method: 'POST',
            body: JSON.stringify({
                "ordonnaces": ordonance
            })
        }).then(d => d.json())
            .then(json => {
                console.log(json)
                window.location.href = url
            })
    }

    return <>
        <div className="input-group">
            <span className="input-group-text" id="basic-addon11">
                <i className='bx bx-search-alt-2'></i>
            </span>
            <input onChange={query} type="text" className="form-control" placeholder="Rechercher" aria-label="Username" aria-describedby="basic-addon11" />
        </div>

        {
            medicament.map((med) => {
                return <div key={med.id} className="card mt-2">
                    <div className="d-flex justify-content-between" style={{ margin: '10px' }}>
                        <div>
                            <strong>{med.nom}</strong>  <br />
                            <span>{med.type}</span>
                        </div>
                        <button onClick={e => {
                            addMeds(med)
                        }} className="btn btn-success btn-icon rounded-pill">
                            <i className='bx bxs-plus-circle' ></i>
                        </button>
                    </div>
                </div>
            })
        }

        <div className="card mt-3">

            <div className="card-body">
                <h4>
                    Ordonnace a faire
                </h4>
                <table className="table">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Type</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            ordonance.map(el => <tr key={el.id}>
                                <td>{el.nom}</td>
                                <td>{el.type}</td>
                                <td>
                                    <button onClick={e => removeMed(el)} type="button" className="btn btn-danger btn-icon rounded-pill">
                                        <i className='bx bx-x-circle' ></i>
                                    </button>
                                </td>
                            </tr>)
                        }
                    </tbody>
                </table>
                <button onClick={sendOrdonnance} disabled={ordonance.length <= 0 || sending} className="btn btn-primary mt-2">
                    {
                        sending ? "...Envoie en cours" : "Valider"
                    }
                </button>
            </div>
        </div>
    </>
}